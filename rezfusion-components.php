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
 * Add a shortcode wrapper to download rezfusion components.
 *
 * @param $atts
 *
 * @return string
 */
function rezfusion_component( $atts ) {

  $a = shortcode_atts([
    'element' => 'app',
    'channel' => get_option('rezfusion_hub_channel'),
    'guid' => get_option('rezfusion_hub_guid'),
  ], $atts );

  if(!$a['channel'] || !$a['guid']) {
    return "Rezfusion Component: A 'channel' and a 'guid' attribute are both required";
  }

  $handle = "{$a['channel']}-{$a['guid']}-{$a['element']}";
  $bucket = rezfusion_components_get_bucket(rezfusions_component_env());
  $folder = preg_replace('/[^0-9a-zA-Z_\s]/', '', "{$a['channel']}") .'-' . $a['guid'];

  wp_enqueue_style(
    $handle,
    $bucket . "/$folder/app.css"
  );

  wp_enqueue_script(
    $handle,
    $bucket . "/$folder/bundle.js"
  );

  if($a['element'] === 'details-page' && $post = get_post()) {
    $meta = get_post_meta($post->ID);
    if($meta['rezfusion_hub_item_id']) {
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'components' => [
              'DetailsPage' => [
                'id' => $meta['rezfusion_hub_item_id'][0],
              ],
            ],
          ],
        ]
      );
    }
  }

  if(is_tax()) {
    $object = get_queried_object();
    $meta = get_term_meta($object->term_id);
    wp_localize_script(
      $handle,
      'REZFUSION_COMPONENTS_CONF',
      [
        'settings' => [
          'components' => [
            'SearchProvider' => [
              'filters' => [
                'categoryFilter' => [
                  'categories' => [
                    [
                      'cat_id' => $meta['rezfusion_hub_category_id'][0],
                      'values' => $meta['rezfusion_hub_category_value_id'],
                      'operator' => 'AND',
                    ],
                  ],
                ],
              ],
            ],
          ],
        ],
      ]
    );
  }

  return "<div id={$a['element']}></div>";
}

add_shortcode( 'rezfusion-component', 'rezfusion_component' );

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
  register_setting( 'rezfusion-components', 'rezfusion_hub_guid');
  register_setting( 'rezfusion-components', 'rezfusion_hub_redirect_urls');
  register_setting( 'rezfusion-components', 'rezfusion_hub_env');
  register_setting( 'rezfusion-components', 'rezfusion_hub_sync_items');
  register_setting( 'rezfusion-components', 'rezfusion_hub_sync_items_post_type');
}