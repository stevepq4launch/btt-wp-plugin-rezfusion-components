<?php
/**
 * This template is used by the [rezfusion-item-avail-calendar] shortcode.
 * @var $lodgingItem
 */
?>
<div data-rezfusion-restrictions="<?php print esc_js(json_encode($lodgingItem->item->restrictions)); ?>"
     data-rezfusion-availability="<?php print esc_js(json_encode($lodgingItem->item->availability)); ?>"
     data-rezfusion-prices="<?php print esc_js(json_encode($lodgingItem->item->prices)); ?>"
     class="lodging-item-details__avail-calendar">
</div>
