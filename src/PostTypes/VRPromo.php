<?php

/**
 * @file - Provide a VR promo post type.
 */

namespace Rezfusion\PostTypes;

use Rezfusion\Plugin;

/* use Rezfusion\Repository\CategoryRepository; */
/* use Rezfusion\Plugin; */

/**
 * Class VRPromo
 *
 * @package Rezfusion\PostTypesSimple
 */
class VRPromo extends PostTypeSimple
{

  public function register()
  {
    parent::register();
    add_action('add_meta_boxes', [$this, 'rzf_add_promo_code_meta']);
    add_action('save_post', [$this, 'rzf_save_promo_code_meta'], 10, 2);
    add_action('add_meta_boxes', [$this, 'rzf_add_promo_listing_meta']);
    add_action('save_post', [$this, 'rzf_save_promo_listing_meta'], 10, 2);
  }

  /**
   * @return array
   */
  public function getLabels(): array
  {
    return [
      'name' => _x('Promos', 'Promo General Name', 'rezfusion_components'),
      'singular_name' => _x('Promo', 'Promo Singular Name', 'rezfusion_components'),
      'menu_name' => __('Promos', 'rezfusion_components'),
      'name_admin_bar' => __('Promo', 'rezfusion_components'),
      'archives' => __('Item Archives', 'rezfusion_components'),
      'attributes' => __('Item Attributes', 'rezfusion_components'),
      'parent_item_colon' => __('Parent Item:', 'rezfusion_components'),
      'all_items' => __('All Items', 'rezfusion_components'),
      'add_new_item' => __('Add New Item', 'rezfusion_components'),
      'add_new' => __('Add New', 'rezfusion_components'),
      'new_item' => __('New Item', 'rezfusion_components'),
      'edit_item' => __('Edit Item', 'rezfusion_components'),
      'update_item' => __('Update Item', 'rezfusion_components'),
      'view_item' => __('View Item', 'rezfusion_components'),
      'view_items' => __('View Items', 'rezfusion_components'),
      'search_items' => __('Search Item', 'rezfusion_components'),
      'not_found' => __('Not found', 'rezfusion_components'),
      'not_found_in_trash' => __('Not found in Trash', 'rezfusion_components'),
      'featured_image' => __('Featured Image', 'rezfusion_components'),
      'set_featured_image' => __('Set featured image', 'rezfusion_components'),
      'remove_featured_image' => __('Remove featured image', 'rezfusion_components'),
      'use_featured_image' => __('Use as featured image', 'rezfusion_components'),
      'insert_into_item' => __('Insert into item', 'rezfusion_components'),
      'uploaded_to_this_item' => __('Uploaded to this item', 'rezfusion_components'),
      'items_list' => __('Items list', 'rezfusion_components'),
      'items_list_navigation' => __('Items list navigation', 'rezfusion_components'),
      'filter_items_list' => __('Filter items list', 'rezfusion_components'),
    ];
  }


  /**
   * @return array
   */
  public function getPostTypeDefinition(): array
  {
    return [
      'label' => __('Promo', 'rezfusion_components'),
      'description' => __('Promo Description', 'rezfusion_components'),
      'labels' => $this->getLabels(),
      'supports' => ['custom-fields', 'editor', 'title', 'thumbnail'],
      'hierarchical' => FALSE,
      'public' => TRUE,
      'show_ui' => TRUE,
      'show_in_menu' => TRUE,
      'menu_position' => 5,
      'show_in_admin_bar' => TRUE,
      'show_in_nav_menus' => TRUE,
      'can_export' => TRUE,
      'has_archive' => TRUE,
      'exclude_from_search' => FALSE,
      'publicly_queryable' => TRUE,
      'capability_type' => 'page',
      'show_in_rest' => true,
      'rewrite' => array('with_front' => false, 'slug' => get_option('rezfusion_hub_custom_promo_slug') ?: 'specials')
    ];
  }

  public function rzf_add_promo_listing_meta()
  {
    add_meta_box(
      'rzf-promo-listing-relation',
      'Add Listings',
      [$this, 'rzf_promo_listing_meta_box'],
      'vr_promo',
      'normal'
    );
  }

  public function rzf_promo_listing_meta_box($post)
  {
    $allListings = get_posts(array(
      'post_type' => 'vr_listing',
      'numberposts' => -1,
      'orderby' => 'post_title',
      'order' => 'ASC'
    ));

    $meta_key = 'rzf_promo_listing_value';

    $checkedListings = get_post_meta($post->ID, $meta_key, true) ?: [];
?>
<div class="rzf-promo-listing-checkbox-wrap" style="display: flex; flex-wrap: wrap; display: grid; margin: 0 auto;grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));grid-auto-rows: minmax(25px, auto);">
  <script language="JavaScript">
  function rzfCheckToggle() {
    var checkboxes = document.getElementsByName('promo-listing-checkbox[]');
    for (let i = 0; i < checkboxes.length; i++) {
      const element = checkboxes[i];
      element.checked = true;
    }
  }
  </script>
  <?php foreach ($allListings as $listing) : ?>
  <div class="single-checkbox" style="padding: 0 0.5rem 0.5rem 0; flex: 1 1 150px;">
    <input type="checkbox" name="promo-listing-checkbox[]" id="<?php echo 'rzf-listing-' . $listing->ID; ?>" value="<?php echo $listing->ID ?>" <?php checked(in_array($listing->ID, $checkedListings)); ?> style="margin: 0 0.25rem 0 0;">
    <label for="<?php echo 'rzf-listing-' . $listing->ID; ?>"><?php echo $listing->post_title; ?></label>
  </div>
  <?php endforeach; ?>
</div>

<div class="select-all-wrap" style="padding-top: 15px; text-align: right;">
  <a id="rzf-promo-listing-select-all" class="button button-primary button-large" onclick="rzfCheckToggle()">Select All</a>
</div>

<?php
  }

  public function rzf_save_promo_listing_meta($post_id, $post)
  {
    $post_type = get_post_type_object($post->post_type);

    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
      return $post_id;
    }

    $new_meta_value = (isset($_POST['promo-listing-checkbox']) ? sanitize_html_class($_POST['promo-listing-checkbox']) : '');
    $meta_key = 'rzf_promo_listing_value';
    $meta_value = get_post_meta($post_id, $meta_key, true);

    if ($new_meta_value && '' == $meta_value) {
      add_post_meta($post_id, $meta_key, $new_meta_value, true);
    } elseif ($new_meta_value && $new_meta_value != $meta_value) {
      update_post_meta($post_id, $meta_key, $new_meta_value);
    } elseif ('' == $new_meta_value && $meta_value) {
      delete_post_meta($post_id, $meta_key, $meta_value);
    }
  }

  public function rzf_add_promo_code_meta()
  {
    add_meta_box(
      'promo-code-meta',
      'Promo Code (optional)',
      [$this, 'rzf_promo_code_meta_box'],
      'vr_promo',
      'normal'
    );
  }

  public function rzf_promo_code_meta_box($post)
  { ?>
<p><input type="text" name="promo-code-input" id="promo-code-input" value="<?php echo esc_attr(get_post_meta($post->ID, 'rzf_promo_code_value', true)); ?>"></p>
<?php }


  public function rzf_save_promo_code_meta($post_id, $post)
  {
    $post_type = get_post_type_object($post->post_type);

    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
      return $post_id;
    }

    $new_meta_value = (isset($_POST['promo-code-input']) ? sanitize_html_class($_POST['promo-code-input']) : '');
    $meta_key = 'rzf_promo_code_value';
    $meta_value = get_post_meta($post_id, $meta_key, true);

    if ($new_meta_value && '' == $meta_value) {
      add_post_meta($post_id, $meta_key, $new_meta_value, true);
    } elseif ($new_meta_value && $new_meta_value != $meta_value) {
      update_post_meta($post_id, $meta_key, $new_meta_value);
    } elseif ('' == $new_meta_value && $meta_value) {
      delete_post_meta($post_id, $meta_key, $meta_value);
    }
  }

  public function checkPromoSlug($old_value, $value)
  {
    if ($old_value !== $value) {
      update_option('rezfusion_trigger_rewrite_flush_promo', 1);
      return true;
      show_message('flush set');
    }
  }

  public function delayedPromoFlush()
  {
    if (!$option = get_option('rezfusion_trigger_rewrite_flush_promo')) {
      return false;
    }

    if ($option == 1) {
      Plugin::refreshData();
      flush_rewrite_rules();
      update_option('rezfusion_trigger_rewrite_flush_promo', 0);
    }
    return true;
  }
}