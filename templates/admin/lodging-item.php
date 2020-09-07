<?php
/**
 * @var $items
 */
?>
<h1>Items</h1>
<?php if(isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) : ?>
  <table class="form-table">
    <tr>
      <th>Name</th>
      <th>Beds</th>
      <th>Baths</th>
      <th>ID</th>
    </tr>
    <?php foreach($items->data->lodgingProducts->results as $item) :  ?>
      <tr>
        <td>
          <?php print $item->item->name; ?>
        </td>
        <td>
          <?php print $item->beds; ?>
        </td>
        <td>
          <?php print $item->baths; ?>
        </td>
        <td>
          <?php print $item->item->id; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
