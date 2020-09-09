<?php

/**
 * This template is used by the [rezfusion-item-reviews] shortcode.
 * @var $lodgingItem
 * @var $reviews
 * @var $currentReview
 * @var $stars
 * @var $emptyStars
 * @var $stayDate
 */
?>

<?php if (!empty($lodgingItem->item->reviews)) : ?>

<h2 class="lodging-item-details__section-heading">Reviews</h2>

<hr>

<div class="lodging-item-reviews-list">

  <?php $reviews = $lodgingItem->item->reviews;
  for ($i = 0; $i < count($reviews); $i++) :
    $currentReview = $reviews[$i];
    $stars = $currentReview->rating;
    $emptyStars = 5 - $stars;
    $stayDate = explode("T", $currentReview->arrival)[0];
  ?>

  <div class="lodging-item-review"></div>
  <h3 class="lodging-item-review__heading"><?php print $currentReview->headline; ?></h3>
  <div class="lodging-item-review__rating">
    <?php for ($s = 0; $s < $stars; $s++) : ?>
    <span class="lodging-item-rating__symbol lodging-item-rating__symbol--fill">&#9733;</span>
    <?php endfor ?>
    <?php for ($e = 0; $e < $emptyStars; $e++) : ?>
    <span class="lodging-item-rating__symbol lodging-item-rating__symbol--outline">&#9734;</span>
    <?php endfor ?>
  </div>
  <div class="lodging-item-review__stay-dates">
    <?php print "Stayed on " . date_i18n(get_option('date_format'), strtotime($stayDate)); ?>
  </div>
  <div class="lodging-item-review__guest-name">
    <?php print $currentReview->guest_name; ?>
  </div>
  <div class="lodging-item-review__comment">
    <?php print $currentReview->comment; ?>
  </div>
</div>

<?php endfor; ?>

</div>

<?php endif; ?>