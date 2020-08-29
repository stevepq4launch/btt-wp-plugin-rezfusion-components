<?php
/**
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

<h1>
  <?php print $lodgingItem->item->name; ?>
</h1>

<div>
  Beds: <?php print $lodgingItem->beds; ?>
</div>

<div>
  Baths: <?php print $lodgingItem->baths; ?>
</div>

<div>
  Max Occupancy: <?php print $lodgingItem->occ_total; ?>
</div>

<div>
  <?php print $lodgingItem->item->description; ?>
</div>
