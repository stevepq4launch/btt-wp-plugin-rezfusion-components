<?php
/**
 * @file - Output the URL map displayed in the <head> of the page.
 */

use Rezfusion\Options;

?>
<script type="application/javascript">
  <?php print "window.REZFUSION_COMPONENTS_ITEM_URL_MAP = " . json_encode(get_transient(Options::URL_Map()), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>
