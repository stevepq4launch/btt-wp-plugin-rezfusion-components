<?php

/**
 * This template is used by the [rezfusion-reviews] shortcode.
 * 
 * @var array[] $reviews
 */

use Rezfusion\Helper\StarsRatingRenderer;
use Rezfusion\Options;

$StarsRatingRenderer = new StarsRatingRenderer(Options::maxReviewRating());

?>
<?php if (is_array($reviews) && count($reviews)) : ?>
  <section id="rezfusion-reviews" class="rezfusion-reviews">
    <div class="rezfusion-reviews__section-title-wrap">
      <h2 class="rezfusion-reviews__section-title-wrap__title"><?php _e('Reviews'); ?></h2>
    </div>
    <div class="rezfusion-reviews__list">
      <?php foreach ($reviews as $review) : ?>
        <div class="rezfusion-review" data-review-id="<?php echo $review['id']; ?>">
          <div class="rezfusion-review__border" data-review-index="<?php echo $i; ?>">
            <h3 class="rezfusion-review__title"><?php print $review['title']; ?></h3>
            <div class="rezfusion-review__rating">
              <?php echo $StarsRatingRenderer->render($review['rating']); ?>
            </div>
            <div class="rezfusion-review__comment">
              <?php echo mb_strimwidth($review['review'], 0, 150, '...<span class="pseudo-link">Read More <i class="fa fa-angle-right"></i></span>'); ?>
            </div>
            <div class="rezfusion-review__info flex-row">
              <div class="rezfusion-review__guest-name flex-xs-12 flex-sm-6">
                <?php print $review['guestName']; ?>
              </div>
              <div class="rezfusion-review__stay-dates flex-xs-12 flex-sm-6">
                <em><?php print "Stayed on " . $review['stayDate']; ?></em>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php echo rezfusion_modal_open('rezfusion-review-view-modal'); ?>
    <div>
      <h3 class="rezfusion-review__heading"></h3>
      <!-- Rating -->
      <div class="rezfusion-review__rating"></div>
      <!-- Guest Comment -->
      <div class="rezfusion-review__content"></div>
      <!-- Start Rating Wrap -->
      <div class="rezfusion-review__info">
        <!-- Guest Name -->
        <div class="rezfusion-review__guest-name"></div>
        <!-- Stay Date -->
        <div class="rezfusion-review__stay-date"></div>
      </div>
      <div class="rezfusion-review__buttons-container">
        <button class="rezfusion-review__previous-button">Previous Review</button>
        <button class="rezfusion-review__next-button">Next Review</button>
      </div>
    </div>
    <?php echo rezfusion_modal_close(); ?>
  </section>
<?php endif; ?>
<?php echo do_shortcode('[rezfusion-review-submit-form postid="' . get_the_ID() . '"]'); ?>
<script>
  (function() {
    /**
     * Handle modal component for viewing reviews.
     */
    document.addEventListener('DOMContentLoaded', function() {
      const reviews = <?php echo json_encode($reviews); ?>;
      let modalElement = document.getElementById('rezfusion-review-view-modal');
      let previewModal = rezfusionModal({
        element: modalElement,
        closeElement: modalElement.querySelector('.rezfusion-modal__close')
      });
      rezfusionReviewsModalHandler({
        reviews: reviews,
        triggersElements: document.querySelectorAll('.rezfusion-review'),
        modalInstance: previewModal,
        titleElement: modalElement.querySelector('.rezfusion-review__heading'),
        ratingElement: modalElement.querySelector('.rezfusion-review__rating'),
        contentElement: modalElement.querySelector('.rezfusion-review__content'),
        stayDateElement: modalElement.querySelector('.rezfusion-review__stay-date'),
        guestNameElement: modalElement.querySelector('.rezfusion-review__guest-name'),
        previousReviewButton: modalElement.querySelector('.rezfusion-review__previous-button'),
        nextReviewButton: modalElement.querySelector('.rezfusion-review__next-button')
      });
    });
  })();
</script>