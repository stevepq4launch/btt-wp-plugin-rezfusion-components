<?php

use Rezfusion\Options;
?>
<tr valign="top">
  <th scope="row">Use icons</th>
  <td>
    <input class="featured-properties-configuration__use-icons" type="checkbox" name="<?php echo Options::featuredPropertiesUseIcons(); ?>" <?php echo esc_attr(get_rezfusion_option(Options::featuredPropertiesUseIcons())) ? "checked" : ""; ?> /><br />
  </td>
</tr>
<tr valign="top">
  <th scope="row">Beds label</th>
  <td>
    <input class="featured-properties-configuration__beds-input" type="text" name="<?php echo Options::featuredPropertiesBedsLabel(); ?>" placeholder='"Beds" will be used' value="<?php echo esc_attr(get_rezfusion_option(Options::featuredPropertiesBedsLabel())); ?>" />
  </td>
</tr>
<tr valign="top">
  <th scope="row">Baths label</th>
  <td>
    <input class="featured-properties-configuration__baths-input" type="text" name="<?php echo Options::featuredPropertiesBathsLabel(); ?>" placeholder='"Baths" will be used' value="<?php echo esc_attr(get_rezfusion_option(Options::featuredPropertiesBathsLabel())); ?>" />
  </td>
</tr>
<tr valign="top">
  <th scope="row">Sleeps label</th>
  <td>
    <input class="featured-properties-configuration__sleeps-input" type="text" name="<?php echo Options::featuredPropertiesSleepsLabel(); ?>" placeholder='"Sleeps" will be used' value="<?php echo esc_attr(get_rezfusion_option(Options::featuredPropertiesSleepsLabel())); ?>" />
  </td>
</tr>
<tr valign="top">
  <th scope="row">Select properties that should be featured</th>
  <td>
    <input class="featured-properties-configuration__properties-ids" readonly type="text" name="<?php echo Options::featuredPropertiesIds(); ?>" value="<?php echo esc_attr(get_rezfusion_option(Options::featuredPropertiesIds())); ?>" />
    <div class="featured-properties-configuration__properties-container">
      <div class="featured-properties-configuration__ids-count"></div>
      <div class="featured-properties-configuration__checkbox-list"></div>
    </div>
  </td>
</tr>

<script>
  (function() {
    try {
      const classPrefix = 'featured-properties-configuration__';
      featuredPropertiesConfigurationComponentHandler({
        propertiesDataSource: <?php echo json_encode($propertiesDataSource); ?>,
        propertiesIdsInput: document.querySelector('.' + classPrefix + 'properties-ids'),
        useIconsInput: document.querySelector('.' + classPrefix + 'use-icons'),
        bedsLabelInput: document.querySelector('.' + classPrefix + 'beds-input'),
        bathsLabelInput: document.querySelector('.' + classPrefix + 'baths-input'),
        sleepsLabelInput: document.querySelector('.' + classPrefix + 'sleeps-input'),
        propertiesCheckboxListContainer: document.querySelector('.' + classPrefix + 'checkbox-list'),
        propertiesCountContainer: document.querySelector('.' + classPrefix + 'ids-count'),
        propertyIdField: 'meta_value'
      });
    } catch (err) {
      alert(err.message);
    }
  })();
</script>