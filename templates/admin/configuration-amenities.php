<tr valign="top">
  <th scope="row">Featured Amenities</th>
  <td>
    <?php
    $checked_options_featured = get_option('rezfusion_hub_amenities_featured') ?: [];

    $vr_taxonomies_featured = get_object_taxonomies('vr_listing', 'objects');

    foreach ($vr_taxonomies_featured as $key => $value) :
      $value = $vr_taxonomies_featured[$key]->name;
      $label = $vr_taxonomies_featured[$key]->label;
    ?>
    <label for="<?php echo 'featured-checkbox-' . $key; ?>" style="margin-right: 1rem;">
      <input type="checkbox" class="featured-checkbox" id="<?php echo 'featured-checkbox-' . $key; ?>" name="rezfusion_hub_amenities_featured[]" value="<?php echo $value; ?>" <?php checked(in_array($value, $checked_options_featured)); ?>>
      <?php echo $label; ?>
    </label>
    <?php endforeach; ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">General Amenities</th>
  <td>
    <?php
    $checked_options_general = get_option('rezfusion_hub_amenities_general') ?: [];

    $vr_taxonomies_general = get_object_taxonomies('vr_listing', 'objects');

    foreach ($vr_taxonomies_general as $key => $value) :
      $value = $vr_taxonomies_general[$key]->name;
      $label = $vr_taxonomies_general[$key]->label;
    ?>
    <label for="<?php echo 'general-checkbox-' . $key; ?>" style="margin-right: 1rem;">
      <input type="checkbox" class="general-checkbox" id="<?php echo 'general-checkbox-' . $key; ?>" name="rezfusion_hub_amenities_general[]" value="<?php echo $value; ?>" <?php checked(in_array($value, $checked_options_general)); ?>>
      <?php echo $label; ?>
    </label>
    <?php endforeach; ?>
  </td>
</tr>