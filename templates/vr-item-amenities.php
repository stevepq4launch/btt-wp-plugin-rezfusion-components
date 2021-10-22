<?php

/**
 * This template is used by the [rezfuison-item-amenities] shortcode.
 */

use Rezfusion\Options;
?>

<?php if (!empty(get_rezfusion_option(Options::amenitiesFeatured())) || !empty(get_rezfusion_option(Options::amenitiesGeneral()))) : ?>

<h2 class="lodging-item-details__section-heading">Amenities</h2>

<hr />

<?php if (!empty(get_rezfusion_option(Options::amenitiesFeatured()))) : ?>
<div class="lodging-amenities lodging-amenities--featured">
  <h3 class="lodging-amenities__heading lodging-amenities__heading--featured">Property Highlights</h3>
  <div class="lodging-amenities__list lodging-amenities__list--featured">
    <?php
        $post_id = get_the_ID();
        $featured_amenities = get_rezfusion_option(Options::amenitiesFeatured());
        $property_amenities = get_the_taxonomies($post_id);
        $display_ameninites = array_diff($featured_amenities, $property_amenities);
        foreach ($display_ameninites as $key => $value) {
          $term = get_the_terms($post_id, $value);
          foreach ($term as $key => $value) :
            $name = $term[$key]->name;
            $icon = get_term_meta($term[$key]->term_id, 'icon', true);
        ?>
    <div class="lodging-amenities__item lodging-amenities__item--featured">
      <i class="lodging-amenities__icon lodging-amenities__icon--featured <?php echo $icon; ?>"></i>
      <p class="lodging-amenities__name lodging-amenities__name--featured"><?php echo $name; ?></p>
    </div>
    <?php endforeach;
        } ?>
  </div>
</div>
<?php endif; ?>

<?php if (!empty(get_rezfusion_option(Options::amenitiesGeneral()))) : ?>
<div class="lodging-amenities lodging-amenities--general">
  <h3 class="lodging-amenities__heading lodging-amenities__heading--general">Other Amenities</h3>
  <div class="lodging-amenities__list lodging-amenities__list--general">
    <?php
        $post_id = get_the_ID();
        $general_amenities = get_rezfusion_option(Options::amenitiesGeneral());
        $property_amenities = get_the_taxonomies($post_id);
        $display_ameninites = array_diff($general_amenities, $property_amenities);
        foreach ($display_ameninites as $key => $value) {
          $term = get_the_terms($post_id, $value);
          foreach ($term as $key => $value) :
            $name = $term[$key]->name;
        ?>
    <div class="lodging-amenities__item lodging-amenities__item--general">
      <p class="lodging-amenities__name lodging-amenities__name--general">
        <i class="lodging-amenities__icon lodging-amenities__icon--general fas fa-check"></i>
        <?php echo $name; ?>
      </p>
    </div>
    <?php endforeach;
        } ?>
  </div>
</div>
<?php endif; ?>

<?php endif; ?>
