<?php

use Rezfusion\Helper\FloorPlanHelper;
?>
<?php if (!empty($url)) : ?>
  <section id="rezfusion-floor-plan" class="rezfusion-floor-plan">
    <div class="rezfusion-property__section-title-wrap rezfusion-floor-plan__section-title-wrap">
      <h2 class="rezfusion-property__section-title rezfusion-floor-plan__section-title">Floor Plan</h2>
    </div>
    <div class="rezfusion-floor-plan__display <?php echo 'rezfusion-floor-plan__display--' . $provider; ?>">
      <?php if (!empty($elementSelector)) : ?>
        <script>
          (function() {
            const elementSelector = <?php echo json_encode($elementSelector); ?>;
            const url = <?php echo json_encode($url); ?>;
            const provider = <?php echo json_encode($provider); ?>;
            const element = elementSelector ? document.querySelector(elementSelector) : null;
            if (!elementSelector || !url || !provider || !element) {
              return;
            }
            if (element.hasAttribute('href')) {
              element.href = 'javascript:;';
            }
            element.addEventListener('click', function() {
              if (provider === '<?php echo FloorPlanHelper::truplaceProvider(); ?>') {
                TourWidget("https://tour.TruPlace.com/" + url);
              }
            });
          })();
        </script>
      <?php else : ?>
        <iframe src="<?php echo $url; ?>" class="rezfusion-floor-plan__iframe"></iframe>
      <?php endif; ?>
    </div>
  </section>
<?php endif; ?>