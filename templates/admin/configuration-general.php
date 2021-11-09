<?php

use Rezfusion\Options;
?>
<tr valign="top">
  <th scope="row">Components URL</th>
  <td><input type="text" name="rezfusion_hub_folder" value="<?php echo $rezfusion_hub_folder_value; ?>" />
    <br />
    <label for="rezfusion_hub_folder">Provide the full URL to the components script bundle.
    </label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Environment</th>
  <td>
    <select name="rezfusion_hub_env">
      <option value="dev" <?php print($isDevEnv ? 'selected' : ''); ?>>
        Development
      </option>
      <option value="prd" <?php print($isProdEnv ? 'selected' : ''); ?>>
        Production
      </option>
    </select>
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
    <input type="button" value="<?php _e("Refresh Data"); ?>" id="rezfusion-hub-fetch-data-button" class="button button-primary" />
    <br />
    <label for="rezfusion_hub_fetch_data">
      Use this option to refresh data if you've added new properties.
    </label>
    <div id="rezfusion-hub-fetch-data-message" class="hidden"></div>
  </td>
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
<tr valign="top">
  <th scope="row">Repository Token</th>
  <td>
    <input type="text" name="<?php echo Options::repositoryToken(); ?>" value="<?php echo esc_attr(get_option(Options::repositoryToken())); ?>" />
    <br />
    <label for="<?php echo Options::repositoryToken(); ?>">Enter repository token to be able to use automatic plugin update feature.</label>
  </td>
</tr>
