<?php

/**
 * This template is used by the [rezfusion-global-policies'] shortcode.
 */

use Rezfusion\Options;
?>

<h2 class="lodging-item-details__section-heading">Policies</h2>

<hr />

<div class="lodging-item-policies__list">
  <div class="lodging-item-policies__section lodging-item-policies__section--general">

    <?php if (!empty(get_rezfusion_option(Options::policiesGeneral()))) {
      _e(stripslashes(get_rezfusion_option(Options::policiesGeneral())));
    } ?>

  </div>

  <?php if (!empty(get_rezfusion_option(Options::policiesPets()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--pets">
    <h3 class="lodging-item-policies__subsection-heading">Pets & Service Animals</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesPets()))) {
        _e(stripslashes(get_rezfusion_option(Options::policiesPets())));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_rezfusion_option(Options::policiesPayment()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--payment">
    <h3 class="lodging-item-policies__subsection-heading">Payment Policy</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesPayment()))) {
        _e(stripslashes( get_rezfusion_option(Options::policiesPayment())));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_rezfusion_option(Options::policiesCancellation()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--cancellation">
    <h3 class="lodging-item-policies__subsection-heading">Cancellation Policy</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesCancellation()))) {
        _e(stripslashes(get_rezfusion_option(Options::policiesCancellation())));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_rezfusion_option(Options::policiesChanging()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--changing">
    <h3 class="lodging-item-policies__subsection-heading">Changing Reservations</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesChanging()))) {
        _e(stripslashes(get_rezfusion_option(Options::policiesChanging())));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_rezfusion_option(Options::policiesInsurance()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--insurance">
    <h3 class="lodging-item-policies__subsection-heading">Trip Insurance</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesInsurance()))) {
        _e(stripslashes(get_rezfusion_option(Options::policiesInsurance())));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_rezfusion_option(Options::policiesCleaning()))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--cleaning">
    <h3 class="lodging-item-policies__subsection-heading">Cleaning/Damage Policy</h3>

    <?php if (!empty(get_rezfusion_option(Options::policiesCleaning()))) {
        _e(stripslashes(get_rezfusion_option(Options::policiesCleaning())));
      } ?>

  </div>
  <?php endif; ?>

</div>
