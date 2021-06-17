<?php
/**
 * This template is used by the [rezfusion-lodging-item-photos] shortcode.
 * @var $lodgingItem
 */
?>
<div data-rezfusion-photos="<?php print esc_js(json_encode($lodgingItem->item->images)); ?>" data-rezfusion-item-name="<?php print esc_js(json_encode($lodgingItem->item->name)) ?>" class="lodging-item-details__photos">
</div>
