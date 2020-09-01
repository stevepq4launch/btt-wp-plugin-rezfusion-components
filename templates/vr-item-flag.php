<?php
/**
 * This template is used by the [rezfusion-lodging-item] shortcode. It can be
 * overridden by coping this file into the active theme. The shortcode uses
 * `locate_template` to load the file. So it must be in one of the
 * standard WordPress locations.
 *
 * These shapes are defined at the URL below as `categoryInfo` and `LodgingItem`
 * respectively:
 *
 * https://blueprint.rezfusion.com/ui/graphql
 *
 * You may `print_r($categoryInfo/$lodgingItem)` to see available data in the
 * template.
 *
 * @var $namespace
 * @var $itemid
 */
?>
<div class="lodging-item-flag--<?php print $namespace;?> lodging-item-favorites--item__<?php print $itemid; ?>">
  <button>
    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 24 24" class="rezfusion-components-heart">
      <path
        d="M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944z"
      />
    </svg>
  </button>
</div>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    var el = document.querySelector('.lodging-item-favorites--item__<?php print $itemid; ?> button');
    new window.RezfusionItemFlag(el, '<?php print $namespace; ?>', '<?php print $itemid; ?>');
  });
</script>
