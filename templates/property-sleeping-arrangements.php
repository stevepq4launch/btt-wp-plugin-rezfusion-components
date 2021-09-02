<?php
$roomData = json_encode($lodgingItem->item->rooms);
?>
<h1>Hello world!</h1>
<div class="sleeping-arrangements" data-rezfusion-rooms="<?php print esc_js($roomData); ?>"></div>

