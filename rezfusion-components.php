<?php

/**
 * @package rezfusion_components
 * @version 0.1
 */
/*
Plugin Name: Rezfusion Components
Plugin URI: https://bluetent.com/
Description Embed RezFusion components on your WordPress site.
Author: developers@bluetent.com
Version: 0.1
Author URI: https://bluetent.com
*/

require_once "includes/helpers.php";
require_once "includes/pages.php";
require_once "includes/gql.php";
require_once "includes/post_type.php";
require_once "includes/taxonomies.php";
require_once "includes/shortcodes.php";

/**
 * Provide a rewrite tag for us in generating
 * clean URLs.
 */
function rezfusion_components_rewrite_tags() {
  add_rewrite_tag('%pms_id%', '([^&]+)');
}
add_action('init', 'rezfusion_components_rewrite_tags', 10, 0);

/**
 * If enabled, redirect users when visiting details pages.
 */
function rezfusion_components_redirect() {
  $redirect = get_option('rezfusion_hub_redirect_urls');
  if ( $redirect && isset($_GET['pms_id']) ) {
    $id = sanitize_text_field($_GET['pms_id']);
    $posts = rezfusion_components_get_local_item($id);
    if(!empty($posts) && $link = get_permalink($posts[0]['post_id'])) {
      wp_redirect($link, 301);
      exit();
    }
  }
}

add_action( 'template_redirect', 'rezfusion_components_redirect' );

/**
 * Provide a map of URLs.
 */
function rezfusion_components_add_url_map() {
  echo '<script type="application/javascript">';
  echo "window.REZFUSION_COMPONENTS_ITEM_URL_MAP = " . json_encode(get_transient('rezfusion_hub_url_map'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
  echo '</script>';
}

add_action( 'wp_head', 'rezfusion_components_add_url_map' );

/**
 * Add a page to configure the components.
 */
function rezfusion_components_create_menu() {
  add_menu_page(
    'Rezfusion Components',
    'Rezfusion',
    'administrator',
    'rezfusion_components_config',
    'rezfusion_components_plugin_settings_page'
  );
  add_submenu_page(
    'rezfusion_components_config',
    'Items',
    'Items',
    'administrator',
    'rezfusion_components_items',
    'rezfusion_components_plugin_items_page'
  );
  add_submenu_page(
    'rezfusion_components_config',
    'Categories',
    'Categories',
    'administrator',
    'rezfusion_components_categories',
    'rezfusion_components_plugin_categories_page'
  );

  add_action( 'admin_init', 'rezfusion_components_register_settings' );
}

add_action('admin_menu', 'rezfusion_components_create_menu');

/**
 * Register the settings.
 */
function rezfusion_components_register_settings() {
  register_setting( 'rezfusion-components', 'rezfusion_hub_channel');
  register_setting( 'rezfusion-components', 'rezfusion_hub_folder');
  register_setting( 'rezfusion-components', 'rezfusion_hub_redirect_urls');
  register_setting( 'rezfusion-components', 'rezfusion_hub_env');
  register_setting( 'rezfusion-components', 'rezfusion_hub_sync_items');
  register_setting( 'rezfusion-components', 'rezfusion_hub_sync_items_post_type');
}
