<?php

/**
 * This template is used by the [rezfusion-global-policies'] shortcode.
 */
?>

<h2 class="lodging-item-details__section-heading">Policies</h2>

<hr />

<div class="lodging-item-policies__list">
  <div class="lodging-item-policies__section lodging-item-policies__section--general">

    <?php if (!empty(get_option('rezfusion_hub_policies_general'))) {
      _e(stripslashes(get_option('rezfusion_hub_policies_general')));
    } ?>

  </div>

  <?php if (!empty(get_option('rezfusion_hub_policies_pets'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--pets">
    <h3 class="lodging-item-policies__subsection-heading">Pets & Service Animals</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_pets'))) {
        _e(stripslashes(get_option('rezfusion_hub_policies_pets')));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_option('rezfusion_hub_policies_payment'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--payment">
    <h3 class="lodging-item-policies__subsection-heading">Payment Policy</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_payment'))) {
        _e(stripslashes( get_option('rezfusion_hub_policies_payment')));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_option('rezfusion_hub_policies_cancellation'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--cancellation">
    <h3 class="lodging-item-policies__subsection-heading">Cancellation Policy</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_cancellation'))) {
        _e(stripslashes(get_option('rezfusion_hub_policies_cancellation')));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_option('rezfusion_hub_policies_changing'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--changing">
    <h3 class="lodging-item-policies__subsection-heading">Changing Reservations</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_changing'))) {
        _e(stripslashes(get_option('rezfusion_hub_policies_changing')));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_option('rezfusion_hub_policies_insurance'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--insurance">
    <h3 class="lodging-item-policies__subsection-heading">Trip Insurance</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_insurance'))) {
        _e(stripslashes(get_option('rezfusion_hub_policies_insurance')));
      } ?>

  </div>
  <?php endif; ?>

  <?php if (!empty(get_option('rezfusion_hub_policies_cleaning'))) : ?>
  <hr />
  <div class="lodging-item-policies__section lodging-item-policies__section--cleaning">
    <h3 class="lodging-item-policies__subsection-heading">Cleaning/Damage Policy</h3>

    <?php if (!empty(get_option('rezfusion_hub_policies_cleaning'))) {
        _e(stripslashes(get_option('rezfusion_hub_policies_cleaning')));
      } ?>

  </div>
  <?php endif; ?>

</div>
