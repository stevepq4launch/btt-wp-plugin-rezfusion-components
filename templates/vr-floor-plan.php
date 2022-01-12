<?php

use Rezfusion\Helper\FloorPlanHelper;
?>
<div id="rezfusion-floor-plan">
    <?php if (!empty($url)) : ?>
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
    <?php endif; ?>
</div>