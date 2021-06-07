<?php
/**
 * This template is used by the [rezfusion-item-avail-picker] shortcode.
 * @var $lodgingItem
 * @var $channel
 * @var $sps_domain
 * @var $conf_page
 * @var $endpoint
 */
?>
<div data-rezfusion-restrictions="<?php print esc_js(json_encode($lodgingItem->item->restrictions)); ?>"
     data-rezfusion-availability="<?php print esc_js(json_encode($lodgingItem->item->availability)); ?>"
     data-rezfusion-prices="<?php print esc_js(json_encode($lodgingItem->item->prices)); ?>"
     data-rezfusion-item-id="<?php print esc_js($lodgingItem->item->id); ?>"
     data-rezfusion-item-pms-id="<?php print esc_js($lodgingItem->item->remote_id); ?>"
     data-rezfusion-item-type="<?php print esc_js($lodgingItem->item->type); ?>"
     data-rezfusion-channel="<?php print esc_js($channel); ?>"
     data-rezfusion-endpoint="<?php print esc_js($endpoint); ?>"
     data-rezfusion-sps-domain="<?php print esc_js($sps_domain); ?>"
     data-rezfusion-conf-page="<?php print esc_js($conf_page); ?>"
     class="lodging-item-details__avail-picker">
</div>
