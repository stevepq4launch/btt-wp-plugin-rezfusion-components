<?php
/**
 * @file - Provide a VR listing post type.
 */

namespace Rezfusion\PostTypes;

use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Plugin;

/**
 * Class VRListing
 *
 * @package Rezfusion\PostTypes
 */
class VRListing extends PostType {

  /**
   * @return array
   */
  public function getLabels(): array {
    return [
      'name' => _x('Listings', 'Listing General Name', 'rezfusion_components'),
      'singular_name' => _x('Listing', 'Listing Singular Name', 'rezfusion_components'),
      'menu_name' => __('Listings', 'rezfusion_components'),
      'name_admin_bar' => __('Listing', 'rezfusion_components'),
      'archives' => __('Item Archives', 'rezfusion_components'),
      'attributes' => __('Item Attributes', 'rezfusion_components'),
      'parent_item_colon' => __('Parent Item:', 'rezfusion_components'),
      'all_items' => __('All Items', 'rezfusion_components'),
      'add_new_item' => __('Add New Item', 'rezfusion_components'),
      'add_new' => __('Add New', 'rezfusion_components'),
      'new_item' => __('New Item', 'rezfusion_components'),
      'edit_item' => __('Edit Item', 'rezfusion_components'),
      'update_item' => __('Update Item', 'rezfusion_components'),
      'view_item' => __('View Item', 'rezfusion_components'),
      'view_items' => __('View Items', 'rezfusion_components'),
      'search_items' => __('Search Item', 'rezfusion_components'),
      'not_found' => __('Not found', 'rezfusion_components'),
      'not_found_in_trash' => __('Not found in Trash', 'rezfusion_components'),
      'featured_image' => __('Featured Image', 'rezfusion_components'),
      'set_featured_image' => __('Set featured image', 'rezfusion_components'),
      'remove_featured_image' => __('Remove featured image', 'rezfusion_components'),
      'use_featured_image' => __('Use as featured image', 'rezfusion_components'),
      'insert_into_item' => __('Insert into item', 'rezfusion_components'),
      'uploaded_to_this_item' => __('Uploaded to this item', 'rezfusion_components'),
      'items_list' => __('Items list', 'rezfusion_components'),
      'items_list_navigation' => __('Items list navigation', 'rezfusion_components'),
      'filter_items_list' => __('Filter items list', 'rezfusion_components'),
    ];
  }

  /**
   * @throws \Exception
   */
  public function registerTaxonomies() {
    $client = Plugin::apiClient();
    $channel = get_option('rezfusion_hub_channel');
    $categories = $client->getCategories($channel);
    if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
      foreach ($categories->data->categoryInfo->categories as $category) {
        $labels = [
          'name' => _x($category->name, 'taxonomy general name', 'rezfusion_components'),
          'singular_name' => _x($category->name, 'taxonomy singular name', 'rezfusion_components'),
          'search_items' => __('Search ' . $category->name, 'rezfusion_components'),
          'popular_items' => __('Common ' . $category->name, 'rezfusion_components'),
          'all_items' => __('All ' . $category->name, 'rezfusion_components'),
          'edit_item' => __('Edit  ' . $category->name, 'rezfusion_components'),
          'update_item' => __('Update  ' . $category->name, 'rezfusion_components'),
          'add_new_item' => __('Add new  ' . $category->name, 'rezfusion_components'),
          'new_item_name' => __('New ' . $category->name . ':', 'rezfusion_components'),
          'add_or_remove_items' => __('Remove  ' . $category->name, 'rezfusion_components'),
          'choose_from_most_used' => __('Choose from common  ' . $category->name, 'rezfusion_components'),
          'not_found' => __('No '. $category->name .' found.', 'rezfusion_components'),
          'menu_name' => __($category->name, 'rezfusion_components'),
        ];

        $args = [
          'hierarchical' => TRUE,
          'labels' => $labels,
          'show_ui' => TRUE,
          'show_admin_column' => TRUE,
        ];

        register_taxonomy(CategoryRepository::categoryMachineName($category->name), [self::getPostTypeName()], $args);
      }
    }
  }

  /**
   * @return array
   */
  public function getPostTypeDefinition(): array {

    $taxonomies = get_taxonomies([], 'names');
    $rzf = [];
    foreach($taxonomies as $taxonomy) {
      if(strpos($taxonomy, 'rzf') === 0) {
        $rzf[] = $taxonomy;
      }
    }

    return [
      'label' => __('Listing', 'rezfusion_components'),
      'description' => __('Listing Description', 'rezfusion_components'),
      'labels' => $this->getLabels(),
      'supports' => ['custom-fields'],
      'taxonomies' => $rzf,
      'hierarchical' => FALSE,
      'public' => TRUE,
      'show_ui' => TRUE,
      'show_in_menu' => TRUE,
      'menu_position' => 5,
      'show_in_admin_bar' => TRUE,
      'show_in_nav_menus' => TRUE,
      'can_export' => TRUE,
      'has_archive' => FALSE,
      'exclude_from_search' => FALSE,
      'publicly_queryable' => TRUE,
      'capability_type' => 'page',
    ];
  }

  /**
   * @param $columns
   *
   * @return array
   */
  public function getColumns($columns): array {
    $new_columns = [
      'cb' => '<input type="checkbox" />',
      'title' => __('Title'),
      'beds' => __('Beds'),
      'baths' => __('Baths'),
    ];

    foreach($columns as $key => $value) {
      if(strpos($key, 'taxonomy-') === 0) {
        $new_columns[$key] = $value;
      }
    }

    $new_columns['item_id'] = __('Item ID');
    $new_columns['date'] = __('Date');

    return $new_columns;
  }

  /**
   * @param $column
   * @param $post_id
   *
   * @return mixed|void
   */
  public function getColumnContents($column, $post_id ) {
    $meta = get_post_meta($post_id);
    switch($column) {
      case 'beds':
        print $meta['rezfusion_hub_beds'][0];
        break;
      case 'baths':
        print $meta['rezfusion_hub_baths'][0];
        break;
      case 'item_id':
        print $meta['rezfusion_hub_item_id'][0];
        break;
    }
  }

}
