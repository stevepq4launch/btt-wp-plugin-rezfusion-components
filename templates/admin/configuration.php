<?php
/**
 * @file - Display the Rezfusion configuration admin page.
 *
 */
?>
<div class="wrap">
  <h1>Rezfusion Components</h1>
  <form method="post"
        action="/wp-admin/admin.php?page=rezfusion_components_config">
    <?php settings_fields('rezfusion-components'); ?>
    <?php do_settings_sections('rezfusion-components'); ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Channel Domain/URL</th>
        <td><input
            type="text"
            name="rezfusion_hub_channel"
            value="<?php echo esc_attr(get_option('rezfusion_hub_channel')); ?>"/><br />
          <label for="rezfusion_hub_channel">You can find the value for this field in the
            <a href="https://hub.rezfusion.com/">Rezfusion Hub</a> UI by visiting
            your company dashboard and selecting the proper channel.</label>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Components URL</th>
        <td><input
            type="text"
            name="rezfusion_hub_folder"
            value="<?php echo esc_attr(get_option('rezfusion_hub_folder')); ?>"/>
          <br />
          <label for="rezfusion_hub_folder">Provide the full URL to the components script bundle.
          </label>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Environment</th>
        <td>
          <select name="rezfusion_hub_env">
            <option value="dev"
              <?php print (get_option('rezfusion_hub_env', 'prd') === 'dev' ? 'selected' : ''); ?>>
              Development
            </option>
            <option value="prd"
              <?php print (get_option('rezfusion_hub_env', 'prd') === 'prd' ? 'selected' : ''); ?>>
              Production
            </option>
          </select>
        </td>
      </tr>
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
    </table>
    <?php submit_button(); ?>
  </form>
</div>
