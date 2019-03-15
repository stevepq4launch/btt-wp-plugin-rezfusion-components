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
    global $wpdb;
    $id = sanitize_text_field($_GET['pms_id']);
    $posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'rezfusion_hub_item_id' AND  meta_value = '$id' LIMIT 1", ARRAY_A);
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
  $bucket = rezfusion_component_get_bucket(rezfusion_component_env());
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
function rezfusion_component_env() {
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
function rezfusion_component_get_bucket($env = "prd") {
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
function rezfusion_component_get_blueprint_url() {
  $env = rezfusion_component_env();
  if($env === 'prd') {
    return "https://blueprint.rezfusion.com/graphql";
  }
  return "https://dev.blueprint.rescmshost.com/graphql";

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
}

/**
 * Provide some simple settings.
 */
function rezfusion_components_plugin_settings_page() {
  if(!empty($_POST)) {
    rezfusion_components_save_settings_form($_POST);
  }
  print get_option('rezfusion_hub_redirect_urls');
  ?>
  <div class="wrap">
    <h1>Rezfusion Components</h1>
      <form method="post" action="/wp-admin/admin.php?page=rezfusion_components_config">
      <?php settings_fields( 'rezfusion-components' ); ?>
      <?php do_settings_sections( 'rezfusion-components' ); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Channel</th>
          <td><input
              type="text"
              name="rezfusion_hub_channel"
              value="<?php echo esc_attr( get_option('rezfusion_hub_channel') ); ?>" />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">GUID</th>
          <td><input
              type="text"
              name="rezfusion_hub_guid"
              value="<?php echo esc_attr( get_option('rezfusion_hub_guid') ); ?>" />
          </td>
        </tr>
        <tr valign="top">
          <th scope="row">Redirect Details page URLs
            <p><small>Useful when property details pages have been previously created.</small></p>
          </th>
          <td><input
              type="checkbox"
              name="rezfusion_hub_redirect_urls"
              <?php checked( '1', get_option( 'rezfusion_hub_redirect_urls' ) ); ?>
              value="1" /><label for="rezfusion_hub_redirect_urls">
              Redirect `pms_id` query strings to an existing page.
            </label>
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
          <th scope="row">Refresh Item Data
            <p><small>Used to build clean URLs for property pages.</small></p>
          </th>
          <td>
            <input
              type="checkbox"
              name="rezfusion_hub_fetch_data"
              value="1" /><label for="rezfusion_hub_fetch_data">
              Use this option to refresh data if you've added new properties.
            </label>
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php require( ABSPATH . 'wp-admin/admin-footer.php' ); ?>
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
  ];

  foreach($keys as $key) {
    update_option($key, $values[$key]);
  }

  if(!empty($values['rezfusion_hub_fetch_data'])) {
    if(rezfusion_components_cache_item_data()) {
      show_message('Data updated.');
    }
    else {
      show_message('Data not updated.');
    }
  }
}

/**
 * Update item data.
 *
 * This function runs on save of the form.
 *
 * @param null $channel
 *
 * @return bool
 */
function rezfusion_components_cache_item_data($channel = NULL) {
  if(!$channel) {
    $channel = get_option('rezfusion_hub_channel');
  }

  $data = rezfusion_components_get_item_ids($channel);

  if(!empty($data)) {
    set_transient('rezfusion_hub_item_data', $data);
    return TRUE;
  }

  return FALSE;
}

/**
 * Output a list of items that the system
 * currently has cached.
 */
function rezfusion_components_plugin_items_page() {
  $items = get_transient('rezfusion_hub_item_data');
  ?>
  <h1>Items</h1>
  <?php if(isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) : ?>
    <table class="form-table">
      <tr>
        <th>Name</th>
        <th>ID</th>
      </tr>
      <?php foreach($items->data->lodgingProducts->results as $item) :  ?>
        <tr>
          <td>
            <?php print $item->item->name; ?>
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