<?php
/**
 * @file - Take care of synchronizing information into local posts and
 * taxonomies.
 */

namespace Rezfusion\Repository;

use Rezfusion\Client\ClientInterface;

class ItemRepository {

  const ITEM_META_KEY = "rezfusion_hub_item_id";

  /**
   * @var \Rezfusion\Client\ClientInterface
   */
  protected $client;

  /**
   * Provide a way to inject an API client as it is needed.
   *
   * @param \Rezfusion\Client\ClientInterface $client
   */
  public function __construct(ClientInterface $client) {
    $this->client = $client;
  }

  /**
   * @param $channel
   */
  public function updateItems($channel) {

    $items = $this->client->getItems($channel);

    // By default we will sync into the `vr_listing` post type.
    $post_type = get_option('rezfusion_hub_sync_items_post_type', 'vr_listing');

    $args = [
      'post_type' => [$post_type],
      'nopaging' => TRUE,
    ];

    $query = new \WP_Query($args);
    // Rekey the array by ID.
    $local_items = array_reduce($query->posts, function($carry, $item) {
      if(!empty($item->ID)) {
        $meta = get_post_meta($item->ID);
        if(isset($meta['rezfusion_hub_item_id'][0])) {
          $carry[$meta['rezfusion_hub_item_id'][0]] = $item;
        }
      }
      return $carry;
    }, []);

    if (isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) {
      $urls = [];
      foreach($items->data->lodgingProducts->results as $result) {
        $id = $result->item->id;
        $data = [
          'post_type' => $post_type,
          'post_status' => 'publish',
          'post_title' => $result->item->name,
          'meta_input' => [
            'rezfusion_hub_item_id' => $result->item->id,
            'rezfusion_hub_beds' => $result->beds,
            'rezfusion_hub_baths' => $result->baths,
          ],
        ];
        if(!empty($local_items[$id])) {
          $post_id = wp_update_post([
              'ID' => $local_items[$id]->ID,
            ] + $data);
          // Remove from the list. This'll
          // let us know which items
          // need to unpublished.
          unset($local_items[$id]);
        }
        else {
          $post_id = wp_insert_post($data);
        }

        // Add tags to items.
        $this->processItemCategories($result->item, $post_id);

        // Add item to the URL map.
        $urls[$result->item->id] = get_permalink($post_id);
      }

      // Cache the URL map.
      set_transient('rezfusion_hub_url_map', $urls);

      // These are missing from Blueprint.
      // So unpublish them.
      if(!empty($local_items)) {
        $data = [
          'post_status' => 'draft',
        ];
        foreach($local_items as $local_item) {
          wp_update_post([
              'ID' => $local_item->ID,
            ] + $data);
        }
      }
    }
  }

  /**
   * Perform tagging of local items during item update. This is not part
   * of the public repository API.
   *
   * @param $apiItem
   * @param $post
   */
  private function processItemCategories($apiItem, $post) {
    if (empty($apiItem->category_values)) {
      return;
    }

    $values = array_map(function($value) {
      return $value->value->id;
    }, $apiItem->category_values);

    $args = [
      'hide_empty' => FALSE,
      'fields' => 'all',
      'count' => TRUE,
      'meta_query' => [
        [
          'key' => 'rezfusion_hub_category_value_id',
          'value' => $values,
          'compare' => 'IN',
        ],
      ],
    ];

    $taxonomies = [];
    $query = new \WP_Term_Query($args);
    if(!empty($query->terms)) {
      $taxonomies = array_reduce($query->terms, function($carry, $item) {
        if(!isset($carry[$item->taxonomy])) {
          $carry[$item->taxonomy] = [$item->term_id];
        }
        else {
          $carry[$item->taxonomy][] = $item->term_id;
        }
        return $carry;
      }, []);
    }

    foreach($taxonomies as $taxonomy => $term_ids) {
      wp_set_post_terms($post, $term_ids, $taxonomy);
    }
  }

  /**
   * Get an item by its Hub id.
   *
   * @param $id
   *
   * @return array|null|object
   */
  public function getItemById($id) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rezfusion_hub_item_id' AND  meta_value = '$id' LIMIT 1", ARRAY_A);
  }

  /**
   * Get all items.
   * 
   * @return array
   */
  public function getAllItems(){
    global $wpdb;
    return is_array(
      $items = $wpdb->get_results("SELECT pm.*, p.post_title FROM $wpdb->postmeta AS pm LEFT JOIN $wpdb->posts AS p ON p.id = pm.post_id WHERE pm.meta_key = '" . static::ITEM_META_KEY . "' AND pm.meta_value IS NOT NULL ORDER BY p.post_title ASC LIMIT 100", ARRAY_A)
    ) ? $items : [];
  }

  /**
   * Get all items keys (meta_value) from post_meta.
   * 
   * @return string[]
   */
  public function getAllItemsIds(){
    global $wpdb;
    return is_array(
      $items = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '" . static::ITEM_META_KEY . "' AND meta_value IS NOT NULL LIMIT 100", ARRAY_A)
    ) ? array_column($items, 'meta_value') : [];
  }

  /**
   * Fetch ids of properties with active promo-codes.
   * 
   * @return string[]
   */
  public function getPromoCodePropertiesIds(){
    global $wpdb;
    $propertiesIds = [];
    $postsIds = [];

    $results = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'rzf_promo_listing_value' AND (meta_value IS NOT NULL AND meta_value != '') LIMIT 100", ARRAY_A);
    foreach($results as $result){
      $metaValues = unserialize($result['meta_value']);
      foreach($metaValues as $postId_){
        if(!in_array($postId = intval($postId_), $postsIds)){
          $postsIds[] = $postId;
        }
      }
    }
    if(count($postsIds)){
      $results2 = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'rezfusion_hub_item_id' AND (meta_value IS NOT NULL AND meta_value != '') AND post_id IN (".join(',', $postsIds).") LIMIT 100", ARRAY_A);
      foreach($results2 as $record){
        if(!empty($record['meta_value']))
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
  public function getPropertyKeyByPostId($postId): string {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value IS NOT NULL AND post_id = %d LIMIT 1", [static::ITEM_META_KEY, $postId]));
  }

}
