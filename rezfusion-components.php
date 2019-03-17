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
      wp_add_inline_script(
        $handle,
        'window.REZFUSION_COMPONENTS_CONF = { settings: { components: { DetailsPage: { id: "'. $meta['rezfusion_hub_item_id'][0] .'" } } } }',
        'before'
      );
    }
  }

  return "<div id={$a['element']}></div>";
}

add_shortcode( 'rezfusion-component', 'rezfusion_component' );

/**
 * Provide a helper function to describe the environement.
 *
 * @return string
 *
 */
function rezfusions_component_env() {
  $env = get_option('rezfusion_hub_env');
  if(empty($env)) {
    return 'prd';
  }

  return $env;
}

/**
 * Get the bucket name to use.
 *
 * @param $env
 *
 * @return string
 */
function rezfusion_components_get_bucket($env = "prd") {
  $suffix = "";
  if($env !== "prd") {
    $suffix = "-dev";
  }
  return "https://s3-us-west-2.amazonaws.com/rezfusion-components-storage$suffix";
}

/**
 * Get the URL for Blueprint.
 *
 * @return string
 */
function rezfusion_components_get_blueprint_url() {
  $env = rezfusions_component_env();
  if($env === 'prd') {
    return "https://blueprint.rezfusion.com/graphql";
  }
  return "https://dev.blueprint.rescmshost.com/graphql";

}

function rezfusion_components_get_local_item($id) {
  global $wpdb;
  return $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rezfusion_hub_item_id' AND  meta_value = '$id' LIMIT 1", ARRAY_A);
}

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

/**
 * Provide some simple settings.
 */
function rezfusion_components_plugin_settings_page() {
  if (!empty($_POST)) {
    rezfusion_components_save_settings_form($_POST);
  }
  ?>
  <div class="wrap">
    <h1>Rezfusion Components</h1>
    <form method="post"
          action="/wp-admin/admin.php?page=rezfusion_components_config">
      <?php settings_fields('rezfusion-components'); ?>
      <?php do_settings_sections('rezfusion-components'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Channel</th>
          <td><input
              type="text"
              name="rezfusion_hub_channel"
              value="<?php echo esc_attr(get_option('rezfusion_hub_channel')); ?>"/>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">GUID</th>
          <td><input
              type="text"
              name="rezfusion_hub_guid"
              value="<?php echo esc_attr(get_option('rezfusion_hub_guid')); ?>"/>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Environment</th>
          <td>
            <select name="rezfusion_hub_env">
              <option value="dev"
                <?php print (get_option('rezfusion_hub_env') === 'dev' ? 'selected' : ''); ?>>
                Development
              </option>
              <option value="prd"
                <?php print (get_option('rezfusion_hub_env') === 'prd' ? 'selected' : ''); ?>>
                Production
              </option>
            </select>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Redirect Item URLs
            <p>
              <small>Useful when you have existing pages and would like to
                redirect to URLs which already exist.
              </small>
            </p>
          </th>
          <td><input
              type="checkbox"
              name="rezfusion_hub_redirect_urls"
              <?php checked('1', get_option('rezfusion_hub_redirect_urls')); ?>
              value="1"/><label for="rezfusion_hub_redirect_urls">
              Redirect `pms_id` query strings to an existing page.
            </label>
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Sync Item Data
            <p>
              <small>Useful when you'd like to provide clean URLs for properties
                and add additional metadata.
              </small>
            </p>
          </th>
          <td><input
              type="checkbox"
              name="rezfusion_hub_sync_items"
              <?php checked('1', get_option('rezfusion_hub_sync_items')); ?>
              value="1"/><label for="rezfusion_hub_sync_items">
              Sync item data to a local Post Type
            </label>
          </td>
        </tr>
        <?php if (get_option('rezfusion_hub_sync_items')) : ?>
          <tr valign="top">
            <th scope="row">Post Type</th>
            <td>
              <select name="rezfusion_hub_sync_items_post_type">
                <?php foreach(get_post_types([], 'object') as $slug => $post_type) : ?>
                <option value="<?php print $slug  ?>"
                  <?php selected($slug, get_option('rezfusion_hub_sync_items_post_type')); ?>>
                  <?php print $post_type->label; ?>
                </option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">Refresh Item Data</th>
            <td>
              <input
                type="checkbox"
                name="rezfusion_hub_fetch_data"
                value="1"/><label for="rezfusion_hub_fetch_data">
                Use this option to refresh data if you've added new properties.
              </label>
            </td>
          </tr>
        <?php endif; ?>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php }

/**
 * Save our settings form.
 *
 * @param $values
 */
function rezfusion_components_save_settings_form($values) {
  $keys = [
    'rezfusion_hub_channel',
    'rezfusion_hub_guid',
    'rezfusion_hub_env',
    'rezfusion_hub_redirect_urls',
    'rezfusion_hub_sync_items',
    'rezfusion_hub_sync_items_post_type',
  ];

  foreach($keys as $key) {
    update_option($key, $values[$key]);
  }

  if(!empty($values['rezfusion_hub_fetch_data'])) {
    try {
      rezfusion_components_update_item_data();
      show_message('Data updated.');
    }
    catch(Exception $e) {
      show_message('Data not updated.');
    }
  }
}

/**
 * Output a list of items that the system
 * currently has cached.
 */
function rezfusion_components_plugin_items_page() {
  $items = get_transient('rezfusion_hub_item_data');
  if(!$items) {
    rezfusion_components_cache_item_data();
    $items = get_transient('rezfusion_hub_item_data');
  }
  ?>
  <h1>Items</h1>
  <?php if(isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) : ?>
    <table class="form-table">
      <tr>
        <th>Name</th>
        <th>Beds</th>
        <th>Baths</th>
        <th>ID</th>
      </tr>
      <?php foreach($items->data->lodgingProducts->results as $item) :  ?>
        <tr>
          <td>
            <?php print $item->item->name; ?>
          </td>
          <td>
            <?php print $item->beds; ?>
          </td>
          <td>
            <?php print $item->baths; ?>
          </td>
          <td>
            <?php print $item->item->id; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <?php
}

/**
 * Output a list of categories that the system
 * currently has cached.
 */
function rezfusion_components_plugin_categories_page() {
  $categories = get_transient('rezfusion_hub_category_data');
  if(!$categories) {
    rezfusion_components_cache_category_data();
    $categories = get_transient('rezfusion_hub_category_data');
  }
  ?>
  <h1>Categories</h1>
  <?php if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) : ?>
    <table class="form-table">
      <tr>
        <th>Name</th>
        <th>Values</th>
        <th>Remote ID</th>
      </tr>
      <?php foreach($categories->data->categoryInfo->categories as $item) :  ?>
        <tr>
          <td>
            <?php print $item->name; ?>
          </td>
          <td>
            <?php if(!empty($item->values)) : ?>
              <?php foreach($item->values as $value) : ?>
                <ul>
                  <li><?php print $value->name; ?> (id: <?php print $value->id; ?>)</li>
                </ul>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
          <td>
            <?php print $item->id; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <?php
}