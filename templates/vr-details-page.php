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
 * @var $categoryInfo
 * @var $lodgingItem
 */
?>
<div class="lodging-item">
  <h1>
    <?php print do_shortcode("[rezfusion-item-flag namespace=\"rezfusion-favorites\" itemid=\"{$lodgingItem->item->id}\"]"); ?>
    <?php print $lodgingItem->item->name; ?>
  </h1>

  <div class="lodging-item-details__beds">
    Beds: <?php print $lodgingItem->beds; ?>
  </div>

  <div class="lodging-item-details__baths">
    Baths: <?php print $lodgingItem->baths; ?>
  </div>

  <div class="lodging-item-details__occ">
    Max Occupancy: <?php print $lodgingItem->occ_total; ?>
  </div>

  <div class="lodging-item-details__description">
    <?php print $lodgingItem->item->description; ?>
  </div>
</div>
