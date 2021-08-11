<tr valign="top">
  <th scope="row">Channel Domain/URL</th>
  <td><input type="text" name="rezfusion_hub_channel" value="<?php echo esc_attr(get_option('rezfusion_hub_channel')); ?>" /><br />
    <label for="rezfusion_hub_channel">You can find the value for this field in the
      <a href="https://hub.rezfusion.com/">Rezfusion Hub</a> UI by visiting
      your company dashboard and selecting the proper channel.</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Components URL</th>
  <td><input type="text" name="rezfusion_hub_folder" value="<?php echo esc_attr(get_option('rezfusion_hub_folder')); ?>" />
    <br />
    <label for="rezfusion_hub_folder">Provide the full URL to the components script bundle.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Environment</th>
  <td>
    <select name="rezfusion_hub_env">
      <option value="dev" <?php print(get_option('rezfusion_hub_env', 'prd') === 'dev' ? 'selected' : ''); ?>>
        Development
      </option>
      <option value="prd" <?php print(get_option('rezfusion_hub_env', 'prd') === 'prd' ? 'selected' : ''); ?>>
        Production
      </option>
    </select>
  </td>
</tr>
<tr valign="top">
  <th scope="row">SPS Domain</th>
  <td>
    <input type="text" name="rezfusion_hub_sps_domain" value="<?php echo esc_attr(get_option('rezfusion_hub_sps_domain')); ?>" />
    <br />
    <label for="rezfusion_hub_sps_domain">Provide the hostname/domain to use for SPS. This option is only configurable
      during development.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Booking Confirmation URL</th>
  <td><input type="text" name="rezfusion_hub_conf_page" value="<?php echo esc_attr(get_option('rezfusion_hub_conf_page')); ?>" />
    <br />
    <label for="rezfusion_hub_conf_page">Provide the full URL to the booking confirmation page.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Post Type</th>
  <td>
    <select name="rezfusion_hub_sync_items_post_type">
      <?php foreach (get_post_types([], 'object') as $slug => $post_type) : ?>
      <option value="<?php print $slug  ?>" <?php selected($slug, get_option('rezfusion_hub_sync_items_post_type', 'vr_listing')); ?>>
        <?php print $post_type->label; ?>
      </option>
      <?php endforeach; ?>
    </select>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Refresh Item Data</th>
  <td>
    <input type="checkbox" name="rezfusion_hub_fetch_data" value="1" /><label for="rezfusion_hub_fetch_data">
      Use this option to refresh data if you've added new properties.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Enable Favorites</th>
  <td>
    <?php $rzfFavoritesValue = get_option('rezfusion_hub_enable_favorites') ?>
    <input type="checkbox" name="rezfusion_hub_enable_favorites[1]" value="1" <?php checked(isset($rzfFavoritesValue['1'])); ?> /><label for="rezfusion_hub_enable_favorites">
      Check this option to enable favorites functionality.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Google Maps API Key</th>
  <td><input type="text" name="rezfusion_hub_google_maps_api_key" value="<?php echo esc_attr(get_option('rezfusion_hub_google_maps_api_key')); ?>" /> </td>
</tr>
<tr valign="top">
  <th scope="row">Custom Listing Slug</th>
  <td>
    <input type="text" name="rezfusion_hub_custom_listing_slug" value="<?php echo esc_attr(get_option('rezfusion_hub_custom_listing_slug')); ?>" />
    <br />
    <label for="rezfusion_hub_custom_listing_slug">If using the <strong>Listing</strong> post type, you can set a custom slug here. Enter the slug all lowercase and without spaces or slashes, e.g. <i>"vr-listing"</i>.  Defaults to "/vacation-rentals/"</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Custom Promo Slug</th>
  <td>
    <input type="text" name="rezfusion_hub_custom_promo_slug" value="<?php echo esc_attr(get_option('rezfusion_hub_custom_promo_slug')); ?>" />
    <br />
    <label for="rezfusion_hub_custom_promo_slug">Enter the slug all lowercase and without spaces or slashes, e.g. <i>"vr-promos"</i>.  Defaults to "/specials/"</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Promo Code Flag Text</th>
  <td>
    <input type="text" name="rezfusion_hub_promo_code_flag_text" value="<?php echo esc_attr(get_option('rezfusion_hub_promo_code_flag_text')); ?>" />
    <br />
    <label for="rezfusion_hub_promo_code_flag_text">Text on flag for properties with active promo-codes (<i>Default: "Special!"</i>).</label>
  </td>
</tr>