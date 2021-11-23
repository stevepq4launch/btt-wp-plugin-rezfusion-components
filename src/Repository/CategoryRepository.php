<?php
/**
 * @file - Handle caching/storing taxonomies and cateogry information.
 */

namespace Rezfusion\Repository;

use InvalidArgumentException;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Metas;
use Rezfusion\Plugin;
use Rezfusion\Service\CategoriesSlugsFixService;
use RuntimeException;
use SebastianBergmann\Environment\Runtime;

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
   * Find category (term) by external ID.
   * @param string $externalID
   * @param string $taxonomy
   * 
   * @return object|null
   */
  public function findCategory($externalID = '', $taxonomy = ''){
    $terms = get_terms([
      'hide_empty' => false,
      'meta_query' => [
          [
             'key' => Metas::categoryValueId(),
             'value' => $externalID,
             'compare' => '='
          ]
        ],
      'taxonomy'  => $taxonomy,
    ]);
    return isset($terms[0]) ? $terms[0] : null;
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

    $category_values = (new CategoriesSlugsFixService)->fix($category_values);

    foreach ($category_values as $value) {

      if(empty(@$value->wp_taxonomy_name))
        throw new RuntimeException("Taxonomy is not defined.");
      if(empty(@$value->slug))
        throw new RuntimeException("Category slug is not defined.");

      $term = $this->findCategory($value->id, $value->wp_taxonomy_name);

      if (!$term) {
        $term = wp_insert_term($value->name, $value->wp_taxonomy_name, [
          'slug' => $value->slug
        ]);
      } else {
        $updatedTerm = wp_update_term($term->term_id, $value->wp_taxonomy_name, [
          'name' => $value->name,
          'slug' => $value->slug
        ]);
        if(is_wp_error($updatedTerm))
          do_action('is_wp_error_instance', $updatedTerm);
      }

      if(is_wp_error($term)) {
        do_action('is_wp_error_instance', $term);
      }

      if(!$term)
        throw new RuntimeException("Category (term) not found.");

      if (!empty($term)) {
        $termID = is_array($term) ? @$term['term_id'] : @$term->term_id;
        if(empty($termID))
          throw new RuntimeException("Invalid category (term) ID.");
        add_term_meta(
          $termID,
          Metas::categoryValueId(),
          $value->id,
          TRUE
        );
        add_term_meta(
          $termID,
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
