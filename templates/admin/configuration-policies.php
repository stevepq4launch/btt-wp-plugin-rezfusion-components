<?php

use Rezfusion\Options;
?>
<tr valign="top">
  <th scope="row">General Policies</th>
  <td>
    <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label>
    <?php
    $editor_id = Options::policiesGeneral();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Pets & Service Animals Policies</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesPets();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Payment Policy</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesPayment();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Cancellation Policy</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesCancellation();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Changing Reservations Policy</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesChanging();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Trip Insurance Policy</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesInsurance();
    $content = get_rezfusion_option($editor_id);
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Cleaning/Damage Policy</th>
  <td>
    <!-- <label for="rezfusion_hub_policies_general">General policies that are always shown under the policies section.</label> -->
    <?php
    $editor_id = Options::policiesCleaning();
    $content = stripslashes(get_rezfusion_option($editor_id));
    $args = array(
      'textarea_name' => $editor_id,
      'media_buttons' => false,
      'default_editor' => 'tinymce',
      'textarea_rows' => 5,
    );

    wp_editor($content, $editor_id, $args);
    ?>
  </td>
</tr>