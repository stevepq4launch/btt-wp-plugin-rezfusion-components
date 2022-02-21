<?php

/**
 * @file - Take care of synchronizing information into local posts and
 * taxonomies.
 */

namespace Rezfusion\Repository;

use Rezfusion\Client\ClientInterface;
use Rezfusion\Entity\PostPropertyAdapter;
use Rezfusion\Entity\PropertyInterface;
use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\PostStatus;
use Rezfusion\PostTypes;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Service\ItemsUpdateService;
use RuntimeException;

class ItemRepository
{

  /**
   * @var \Rezfusion\Client\ClientInterface
   */
  protected $client;

  /**
   * Provide a way to inject an API client as it is needed.
   *
   * @param \Rezfusion\Client\ClientInterface $client
   */
  public function __construct(ClientInterface $client)
  {
    $this->client = $client;
  }

  /**
   * Returns post type associated with this repository.
   * @return string
   */
  public static function postType(): string
  {
    return OptionsHandlerProvider::getInstance()->getOption(Options::syncItemsPostType(), PostTypes::listing());
  }


  /**
   * Executes items query with filters.
   * @param array $filters
   * 
   * @return PropertyInterface[]
   */
  private function query(array $filters = []): array
  {
    $items = [];
    $args = [
      'fields' => 'ids',
      'post_type' => [$this->postType()],
      'nopaging' => TRUE,
      'orderby' => 'ID',
      'order'   => 'ASC'
    ];

    if (array_key_exists('post_status', $filters) && !empty($filters['post_status'])) {
      $args['post_status'] = $filters['post_status'];
    }

    if (array_key_exists('post_id', $filters) && !empty($filters['post_id'])) {
      $args['post__in'] = $filters['post_id'];
    }

    if (array_key_exists('property_id', $filters) && !empty($filters['property_id'])) {
      $args['meta_key'] = Metas::itemId();
      $args['meta_value'] = $filters['property_id'];
      $args['meta_compare'] = 'IN';
    }

    $Query = new \WP_Query($args);
    if (is_array($Query->posts)) {
      foreach ($Query->posts as $postID) {
        $items[] = $this->findItemByPostId($postID);
      }
    }

    return $items;
  }

  /**
   * @param $channel
   */
  public function updateItems($channel)
  {
    (new ItemsUpdateService($this->client, $channel, $this))->run();
  }

  /**
   * Get an item by its Hub id.
   *
   * @param $id
   *
   * @return array|null|object
   */
  public function getItemById($id)
  {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts p ON p.id = pm.post_id WHERE p.post_status = '" . PostStatus::publishStatus() . "' AND pm.meta_key = '" . Metas::itemId() . "' AND pm.meta_value = '$id' LIMIT 1", ARRAY_A);
  }

  /**
   * Get all items.
   * 
   * @return array
   */
  public function getAllItems()
  {
    global $wpdb;
    return is_array(
      $items = $wpdb->get_results("SELECT pm.*, p.post_title FROM $wpdb->postmeta AS pm LEFT JOIN $wpdb->posts AS p ON p.id = pm.post_id WHERE p.post_status = '" . PostStatus::publishStatus() . "' AND pm.meta_key = '" . Metas::itemId() . "' AND pm.meta_value IS NOT NULL ORDER BY p.post_title ASC LIMIT 100", ARRAY_A)
    ) ? $items : [];
  }

  /**
   * Get all items keys (meta_value) from post_meta.
   * 
   * @return string[]
   */
  public function getAllItemsIds()
  {
    global $wpdb;
    return is_array(
      $items = $wpdb->get_results("SELECT pm.meta_value FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts p ON p.id = pm.post_id WHERE pm.meta_key = '" . Metas::itemId() . "' AND pm.meta_value IS NOT NULL AND p.post_status = '" . PostStatus::publishStatus() . "' LIMIT 100", ARRAY_A)
    ) ? array_column($items, 'meta_value') : [];
  }

  /**
   * Fetch ids of properties with active promo-codes.
   * 
   * @return string[]
   */
  public function getPromoCodePropertiesIds()
  {
    global $wpdb;
    $propertiesIds = [];
    $postsIds = [];

    $results = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . Metas::promoListingValue() . "' AND (meta_value IS NOT NULL AND meta_value != '') LIMIT 100", ARRAY_A);
    foreach ($results as $result) {
      $metaValues = unserialize($result['meta_value']);
      foreach ($metaValues as $postId_) {
        if (!in_array($postId = intval($postId_), $postsIds)) {
          $postsIds[] = $postId;
        }
      }
    }
    if (count($postsIds)) {
      $results2 = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . Metas::itemId() . "' AND (meta_value IS NOT NULL AND meta_value != '') AND post_id IN (" . join(',', $postsIds) . ") LIMIT 100", ARRAY_A);
      foreach ($results2 as $record) {
        if (!empty($record['meta_value']))
          $propertiesIds[] = $record['meta_value'];
      }
    }

    return $propertiesIds;
  }

  /**
   * Get property key by associated post ID.
   * 
   * @param int $postId
   * 
   * @return string
   */
  public function getPropertyKeyByPostId($postId): string
  {
    global $wpdb;
    return strval($wpdb->get_var($wpdb->prepare("SELECT pm.meta_value FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts p ON p.id = pm.post_id WHERE pm.meta_key = %s AND pm.meta_value IS NOT NULL AND pm.post_id = %d AND p.post_status = '" . PostStatus::publishStatus() . "' LIMIT 1", [Metas::itemId(), $postId])));
  }

  /**
   * Save a new item or update existing one.
   * @param PropertyInterface $Property
   * 
   * @return PropertyInterface
   */
  public function saveItem(PropertyInterface $Property): PropertyInterface
  {
    $Property->setPostType(static::postType()); // Post type is forced by repository.
    $returnedPostId = null;
    $data = [
      'post_type' => $Property->getPostType(),
      'post_status' => $Property->getPostStatus(),
      'post_title' => $Property->getName(),
      'meta_input' => [
        Metas::itemId() => $Property->getId(),
        Metas::beds() => $Property->getBeds(),
        Metas::baths() => $Property->getBaths()
      ]
    ];
    $postId = $Property->getPostId();

    if (!empty($postId)) {
      $data['ID'] = $postId;
    }

    if (!empty($Property->getId()) && empty($Property->getPostId())) {
      $existingItem = $this->query([
        'post_status' => [
          PostStatus::draftStatus(),
          PostStatus::trashStatus(),
          PostStatus::publishStatus()
        ],
        'property_id' => [
          $Property->getId()
        ]
      ]);
      if (!empty($existingItem)) {
        throw new RuntimeException('Property item exists in database.');
      }
    }

    $returnedPostId = empty($postId) ? wp_insert_post($data) : wp_update_post($data);

    if (is_wp_error($returnedPostId) || empty($returnedPostId) || !is_int($returnedPostId)) {
      throw new \Error('Post was not saved.');
    }

    $Property->setPostId($returnedPostId);

    return $Property;
  }

  /**
   * Find single item by property ID.
   * @param string $id
   * 
   * @return PropertyInterface|null
   */
  public function findItem(string $id)
  {
    $item = $this->getItemById($id);
    return (isset($item[0]['post_id']) && !empty($item[0]['post_id'])) ? $this->findItemByPostId($item[0]['post_id']) : null;
  }

  /**
   * Find single item by post ID.
   * @param int $postId
   * 
   * @return PropertyInterface|null
   */
  public function findItemByPostId(int $postId)
  {
    $post = get_post($postId);
    if (empty($post)) {
      return null;
    }
    $meta = get_post_meta($postId);
    return new PostPropertyAdapter($post, $meta);
  }

  /**
   * Fetches all items using passed filtering.
   * @param string[] $statuses
   * 
   * @return PropertyInterface[]
   */
  public function findItems(array $statuses = [], array $propertiesIds = []): array
  {
    $filters = [
      'post_status' => (empty($statuses)) ? [PostStatus::publishStatus()] : $statuses
    ];
    if (!empty($propertiesIds)) {
      $filters['property_id'] = $propertiesIds;
    }
    return $this->query($filters);
  }
}
