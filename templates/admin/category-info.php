<?php
/**
 * @var $categories
 */
?>
<h1>Categories</h1>
<?php if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) : ?>
  <table class="form-table">
    <tr>
      <th>Name</th>
      <th>Values</th>
      <th>Remote ID</th>
    </tr>
    <?php foreach($categories->data->categoryInfo->categories as $item) :  ?>
      <tr>
        <td>
          <?php print $item->name; ?>
        </td>
        <td>
          <?php if(!empty($item->values)) : ?>
            <?php foreach($item->values as $value) : ?>
              <ul>
                <li><?php print $value->name; ?> (id: <?php print $value->id; ?>)</li>
              </ul>
            <?php endforeach; ?>
          <?php endif; ?>
        </td>
        <td>
          <?php print $item->id; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
