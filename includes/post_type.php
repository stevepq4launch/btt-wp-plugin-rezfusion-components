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

  $labels = [
    'name' => _x('Listings', 'Listing General Name', 'text_domain'),
    'singular_name' => _x('Listing', 'Listing Singular Name', 'text_domain'),
    'menu_name' => __('Listings', 'text_domain'),
    'name_admin_bar' => __('Listing', 'text_domain'),
    'archives' => __('Item Archives', 'text_domain'),
    'attributes' => __('Item Attributes', 'text_domain'),
    'parent_item_colon' => __('Parent Item:', 'text_domain'),
    'all_items' => __('All Items', 'text_domain'),
    'add_new_item' => __('Add New Item', 'text_domain'),
    'add_new' => __('Add New', 'text_domain'),
    'new_item' => __('New Item', 'text_domain'),
    'edit_item' => __('Edit Item', 'text_domain'),
    'update_item' => __('Update Item', 'text_domain'),
    'view_item' => __('View Item', 'text_domain'),
    'view_items' => __('View Items', 'text_domain'),
    'search_items' => __('Search Item', 'text_domain'),
    'not_found' => __('Not found', 'text_domain'),
    'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
    'featured_image' => __('Featured Image', 'text_domain'),
    'set_featured_image' => __('Set featured image', 'text_domain'),
    'remove_featured_image' => __('Remove featured image', 'text_domain'),
    'use_featured_image' => __('Use as featured image', 'text_domain'),
    'insert_into_item' => __('Insert into item', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
    'items_list' => __('Items list', 'text_domain'),
    'items_list_navigation' => __('Items list navigation', 'text_domain'),
    'filter_items_list' => __('Filter items list', 'text_domain'),
  ];
  $args = [
    'label' => __('Listing', 'text_domain'),
    'description' => __('Listing Description', 'text_domain'),
    'labels' => $labels,
    'supports' => ['custom-fields'],
    'taxonomies' => ['category', 'post_tag'],
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
  register_post_type('vr_listing', $args);

}

add_action('init', 'rezfusion_components_register_post_types', 0);