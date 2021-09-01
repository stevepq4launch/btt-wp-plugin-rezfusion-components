<?php
$roomData = json_encode($lodgingItem->item->rooms);
?>

<div class="sleeping-arrangements" data-rezfusion-rooms="<?php print esc_js($roomData); ?>"></div>

