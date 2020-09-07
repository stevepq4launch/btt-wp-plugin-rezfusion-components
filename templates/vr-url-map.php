<?php
/**
 * @file - Output the URL map displayed in the <head> of the page.
 */
?>
<script type="application/javascript">
  <?php print "window.REZFUSION_COMPONENTS_ITEM_URL_MAP = " . json_encode(get_transient('rezfusion_hub_url_map'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>
