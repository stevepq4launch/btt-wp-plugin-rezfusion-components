<?php
/**
 * @file - Provide custom taxonomies.
 */
function rezfusion_components_register_taxonomy() {

  $sync_listing_data = get_option('rezfusion_hub_sync_items');
  $post_type = get_option('rezfusion_hub_sync_items_post_type', 'vr_listing');

  if(!$sync_listing_data) {
    return;
  }

  $categories = get_transient('rezfusion_hub_category_data');
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
      ];

      register_taxonomy(str_replace('-', '_', sanitize_title($category->name)), [$post_type], $args);
    }
  }

}

add_action('init', 'rezfusion_components_register_taxonomy');
