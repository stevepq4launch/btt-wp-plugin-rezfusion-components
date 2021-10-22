<?php

use Rezfusion\Options;
?>
<tr valign="top">
  <th scope="row">Review Button Text</th>
  <td><input type="text" name="rezfusion_hub_review_btn_text" value="<?php echo esc_attr(get_rezfusion_option(Options::reviewButtonText())); ?>" /><br />
    <label for="rezfusion_hub_review_btn_text">Set custom text for the add review button if desired. Default text is "Add a Review".</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Review Form Shortcode</th>
  <td><input type="text" name="rezfusion_hub_review_form" value="<?php echo esc_attr(stripslashes(get_rezfusion_option(Options::reviewForm()))); ?>" /><br />
    <label for="rezfusion_hub_review_form">Set the shortcode used to display review submission form.</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Inquiry Form Button Text</th>
  <td><input type="text" name="rezfusion_hub_inquiry_btn_text" value="<?php echo esc_attr(get_rezfusion_option(Options::inquiryButtonText())); ?>" /><br />
    <label for="rezfusion_hub_inquiry_btn_text">Set custom text for the inquiry form button if desired. Default text is "Request Information".</label>
  </td>
</tr>
<tr valign="top">
  <th scope="row">Inquiry Form Shortcode</th>
  <td><input type="text" name="rezfusion_hub_inquiry_form" value="<?php echo esc_attr(stripslashes(get_rezfusion_option(Options::inquiryForm()))); ?>" /><br />
    <label for="rezfusion_hub_inquiry_form">Set the shortcode used to display inquiry form.</label>
  </td>
</tr>