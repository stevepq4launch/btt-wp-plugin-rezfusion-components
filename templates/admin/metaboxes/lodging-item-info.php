<?php
/**
 * @file - Display basic property information as received from Blueprint.
 *
 * @var \WP_Post $post
 * @var array $meta - The post meta
 */
?>
<div class="lodging-item--info">
  <h1>
    <?php print $post->post_title; ?>
  </h1>
  <div>
    Item ID: <?php print $meta['rezfusion_hub_item_id'][0]; ?>
  </div>
  <div>
    Beds: <?php print $meta['rezfusion_hub_beds'][0]; ?>
  </div>
  <div>
    Baths: <?php print $meta['rezfusion_hub_baths'][0]; ?>
  </div>
</div>
