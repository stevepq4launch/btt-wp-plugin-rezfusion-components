<?php

use Rezfusion\Helper\FloorPlanHelper;
?>
<?php if (!empty($url)) : ?>
  <section id="rezfusion-floor-plan" class="rezfusion-floor-plan">
    <div class="rezfusion-property__section-title-wrap rezfusion-floor-plan__section-title-wrap">
      <h2 class="rezfusion-property__section-title rezfusion-floor-plan__section-title">Floor Plan</h2>
    </div>
    <div class="rezfusion-floor-plan__display <?php echo 'rezfusion-floor-plan__display--' . $provider; ?>">
      <?php if ($provider === FloorPlanHelper::truplaceProvider()) : ?>
        <button class="btn rezfusion-floor-plan__btn" onclick="TourWidget('https://tour.truplace.com/<?php echo $url; ?>');">View Floor Plan</button>
      <?php else : ?>
        <iframe src="<?php echo $url; ?>" class="rezfusion-floor-plan__iframe"></iframe>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>