<?php
/**
 * @file - Handle caching/storing taxonomies and cateogry information.
 */

namespace Rezfusion\Repository;

use InvalidArgumentException;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Metas;
use Rezfusion\Plugin;

class CategoryRepository {

  /**
   * @var \Rezfusion\Client\ClientInterface
   */
  protected $client;

  /**
   * ItemRepository constructor.
   *
   * Constructor inject a `Client` so that we can have flexibility
   * for how items are queried from the API in the future.
   *
   * @param \Rezfusion\Client\ClientInterface $client
   */
  public function __construct(ClientInterface $client) {
    $this->client = $client;
  }

  /**
   * @param $category
   *
   * @return string
   */
  public static function categoryMachineName($category): string {
    return Plugin::prefix() . "_" . str_replace('-', '_', sanitize_title($category));
  }

  /**
   * @param $channel
   */
  public function updateCategories($channel) {
    $categories = $this->client->getCategories($channel);
    $taxonomies = [];
    $category_values = [];
    if (isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
      foreach ($categories->data->categoryInfo->categories as $category) {
        $name = self::categoryMachineName($category->name);
        $taxonomies[] = $name;
        if (!empty($category->values)) {
          foreach ($category->values as $value) {
            $value->category_id = $category->id;
            $value->wp_taxonomy_name = $name;
            $category_values[$value->id] = $value;
          }
        }
      }
    }

    if (empty($taxonomies) || empty($category_values)) {
      return;
    }

    $args = [
      'taxonomy' => $taxonomies,
      'hide_empty' => FALSE,
      'fields' => 'all',
      'count' => TRUE,
    ];

    $terms = [];
    $query = new \WP_Term_Query($args);
    if (!empty($query->terms)) {
      $terms = array_reduce($query->terms, function ($carry, $item) {
        if (!empty($item->term_id)) {
          $meta = get_term_meta($item->term_id);
          if (isset($meta[Metas::categoryValueId()][0])) {
            $carry[$meta[Metas::categoryValueId()][0]] = $item;
          }
        }
        return $carry;
      }, []);
    }

    $to_create = array_diff_key($category_values, $terms);

    foreach ($to_create as $value) {
      if (!term_exists( $value->name, $value->wp_taxonomy_name )) {
        $term = wp_insert_term($value->name, $value->wp_taxonomy_name);
      }

      if(is_wp_error($term)) {
        do_action('is_wp_error_instance', $term);
      }

      if (!empty($term)) {
        add_term_meta(
          $term['term_id'],
          Metas::categoryValueId(),
          $value->id,
          TRUE
        );
        add_term_meta(
          $term['term_id'],
          Metas::categoryId(),
          $value->category_id,
          FALSE
        );
      }
    }
  }

  /**
   * Deletes category by it's ID and taxonomy.
   * @param int|string|null $categoryId
   * @param string $taxonomy
   * 
   * @return bool
   */
  public function deleteCategory($categoryId = null, $taxonomy = ''): bool {
    if(empty($categoryId))
      throw new InvalidArgumentException('Invalid category ID.');
    if(empty($taxonomy))
      throw new InvalidArgumentException('Invalid taxonomy.');
    return wp_delete_term($categoryId, $taxonomy);
  }

  /**
   * Returns array of taxonomies names.
   * 
   * @return string[]
   */
  public function getAllTaxonomies(): array {
    global $wpdb;
    return array_reduce(
      $wpdb->get_results($wpdb->prepare("SELECT DISTINCT taxonomy FROM $wpdb->term_taxonomy WHERE taxonomy LIKE %s", ['%rzf_%']), ARRAY_A),
      function($taxonomies, $item){
        if(!empty($item['taxonomy']))
          $taxonomies[] = $item['taxonomy'];
        return $taxonomies;
      }, []
    );
  }

  /**
   * Gets all categories items.
   * 
   * @return object
   */
  public function getCategories() {
    $args = [
      'taxonomy' => $this->getAllTaxonomies(),
      'hide_empty' => FALSE,
      'fields' => 'all',
      'count' => TRUE,
    ];
    $query = new \WP_Term_Query($args);
    return $query->terms;
  }
}
