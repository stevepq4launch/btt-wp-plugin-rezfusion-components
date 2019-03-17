<?php
/**
 * @file -- Optionally provide a custom post type for
 * syncing data.
 */
function rezfusion_components_register_post_types() {

  $sync_listing_data = get_option('rezfusion_hub_sync_items');

  if(!$sync_listing_data) {
    return;
  }

  $categories = get_transient('rezfusion_hub_category_data');
  $category_names = [];
  if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
    foreach ($categories->data->categoryInfo->categories as $category) {
      $category_names[] = str_replace('-', '_', sanitize_title($category->name));
    }
  }

  $labels = [
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
  $args = [
    'label' => __('Listing', 'rezfusion_components'),
    'description' => __('Listing Description', 'rezfusion_components'),
    'labels' => $labels,
    'supports' => ['custom-fields'],
    'taxonomies' => $category_names,
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
    'capabilities' => array(
      'create_posts' => false,
    ),
  ];
  register_post_type('vr_listing', $args);

}

add_action('init', 'rezfusion_components_register_post_types', 0);

/**
 * Add custom columns to our custom content type.
 *
 * @param $columns
 *
 * @return mixed
 */
function rezfusion_components_vr_listing_columns( $columns ) {

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

add_filter('manage_vr_listing_posts_columns', 'rezfusion_components_vr_listing_columns');


/**
 * Add content to custom columns on the vr_listing list screen.
 *
 * @param $column
 * @param $post_id
 */
function rezfusion_components_vr_listing_column( $column, $post_id ) {
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

add_action( 'manage_vr_listing_posts_custom_column', 'rezfusion_components_vr_listing_column', 10, 2);

