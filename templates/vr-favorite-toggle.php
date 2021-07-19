<?php

/**
 * @var $lodgingItem
 * @var string $type
 */
?>

<div class="favorite-toggle" data-rezfusion-item-id="<?php print esc_js(json_encode($lodgingItem->item->id)) ?>" data-rezfusion-item-name="<?php print stripslashes(esc_js(json_encode($lodgingItem->item->name))) ?>" data-rezfusion-toggle-type="<?php print esc_js(json_encode(($type === 'small' || $type === 'large') ? $type : 'small')) ?>"></div>