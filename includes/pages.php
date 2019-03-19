<?php
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
      flush_rewrite_rules();
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