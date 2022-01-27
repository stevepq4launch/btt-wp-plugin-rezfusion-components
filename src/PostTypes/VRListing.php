<?php
/**
 * @file - Provide a VR listing post type.
 */

namespace Rezfusion\PostTypes;

use Rezfusion\Actions;
use Rezfusion\Factory\FloorPlanRepositoryFactory;
use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\Repository\CategoryRepository;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;

/**
 * Class VRListing
 *
 * @package Rezfusion\PostTypes
 */
class VRListing extends PostType {

  public static function floorPlanURL_PostParameter(): string
  {
    return 'floor-plan-url';
  }

  public static function floorPlanColumnName(): string
  {
    return 'floor_plan_url';
  }

  private function floorPlanURL_MetaBoxHTML(object $post): string
  {
    return '<p><input type="text" name="' . static::floorPlanURL_PostParameter() . '" id="floor-plan-url-input" class="form-field floor-plan-url-input" value="' . esc_attr(get_post_meta($post->ID, Metas::postFloorPlanURL(), true)) . '"></p>';
  }

  private function addFloorPlanURL_MetaBox(): void
  {
    add_meta_box(
      'rzf-listing-floor-plan-url',
      'Custom Floor Plan URL',
      function(object $post){
        echo $this->floorPlanURL_MetaBoxHTML($post);
      },
      $this->getPostTypeName(),
      'normal'
    );
  }

  private function registerStyle(): void {
    global $pagenow;
    if (
      $pagenow === 'post.php' && isset($_GET['post']) && $this->getPostTypeName() === get_post_type($_GET['post'])
      || $pagenow === 'edit.php' && isset($_GET['post_type']) && $this->getPostTypeName() === $_GET['post_type']
      ) {
      Plugin::getInstance()->getAssetsRegisterer()->handleStyle('rezfusion.css');
    }
  }

  private function handleFloorPlanURL_Save(int $post_id, object $post)
  {
    $post_type = get_post_type_object($post->post_type);
    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
      return $post_id;
    }
    $postVariable = static::floorPlanURL_PostParameter();
    $newURL = (isset($_POST[$postVariable]) ? $_POST[$postVariable] : '');
    $FloorPlanRepository = (new FloorPlanRepositoryFactory())->make();
    $FloorPlanRepository->save($post_id, $newURL);
  }

  public function register(){
    parent::register();
    $taxonomies = get_object_taxonomies(PostTypes::listing(), 'names');
    foreach($taxonomies as $taxonomy) {
      add_action(Actions::taxonomyAddFormFields($taxonomy) , [$this, 'addIconPicker'], 10, 2);
      add_action(Actions::createdTaxonomy($taxonomy) , [$this, 'saveIconPicker'], 10, 2);
      add_action(Actions::taxonomyEditFormFields($taxonomy) , [$this, 'editIconPicker'], 10, 2);
      add_action(Actions::editedTaxonomy($taxonomy) , [$this, 'updateIconPicker'], 10, 2);
    }
    add_action(Actions::addMetaBoxes(), function(){
      $this->addFloorPlanURL_MetaBox();
    });
    add_action(Actions::savePost(), function($post_id, $post){
      $this->handleFloorPlanURL_Save($post_id, $post);
    }, 10, 2);
    add_action(Actions::adminEnqueueScripts(), function(){
      $this->registerStyle();
    });
  }

  /**
   * @return array
   */
  public function getLabels(): array {
    return [
      'name' => _x('Listings', 'Listing General Name', 'rezfusion_components'),
      'singular_name' => _x('Listing', 'Listing Singular Name', 'rezfusion_components'),
      'menu_name' => __('Listings', 'rezfusion_components'),
      'name_admin_bar' => __('Listing', 'rezfusion_components'),
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
   * @throws \Exception
   */
  public function registerTaxonomies() {
    $client = Plugin::apiClient();
    $channel = get_rezfusion_option(Options::hubChannelURL());
    $categories = $client->getCategories($channel);
    if(isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
      foreach ($categories->data->categoryInfo->categories as $category) {
        $labels = [
          'name' => _x($category->name, 'taxonomy general name', 'rezfusion_components'),
          'singular_name' => _x($category->name, 'taxonomy singular name', 'rezfusion_components'),
          'search_items' => __('Search ' . $category->name, 'rezfusion_components'),
          'popular_items' => __('Common ' . $category->name, 'rezfusion_components'),
          'all_items' => __('All ' . $category->name, 'rezfusion_components'),
          'edit_item' => __('Edit  ' . $category->name, 'rezfusion_components'),
          'update_item' => __('Update  ' . $category->name, 'rezfusion_components'),
          'add_new_item' => __('Add new  ' . $category->name, 'rezfusion_components'),
          'new_item_name' => __('New ' . $category->name . ':', 'rezfusion_components'),
          'add_or_remove_items' => __('Remove  ' . $category->name, 'rezfusion_components'),
          'choose_from_most_used' => __('Choose from common  ' . $category->name, 'rezfusion_components'),
          'not_found' => __('No '. $category->name .' found.', 'rezfusion_components'),
          'menu_name' => __($category->name, 'rezfusion_components'),
        ];

        $args = [
          'hierarchical' => TRUE,
          'labels' => $labels,
          'show_ui' => TRUE,
          'show_admin_column' => TRUE,
          'rewrite' => array( 'with_front' => false, 'slug' => strtolower($category->name) ),
        ];

        register_taxonomy(CategoryRepository::categoryMachineName($category->name), [self::getPostTypeName()], $args);
      }
    }
  }

  /**
   * @return array
   */
  public function getPostTypeDefinition(): array {
    $taxonomies = get_taxonomies([], 'names');
    $rzf = [];
    foreach($taxonomies as $taxonomy) {
      if(strpos($taxonomy, 'rzf') === 0) {
        $rzf[] = $taxonomy;
      }
    }

    return [
      'label' => __('Listing', 'rezfusion_components'),
      'description' => __('Listing Description', 'rezfusion_components'),
      'labels' => $this->getLabels(),
      'supports' => ['custom-fields', 'editor', 'title'],
      'taxonomies' => $rzf,
      'hierarchical' => FALSE,
      'public' => TRUE,
      'show_ui' => TRUE,
      'show_in_menu' => TRUE,
      'menu_position' => 5,
      'show_in_admin_bar' => TRUE,
      'show_in_nav_menus' => TRUE,
      'can_export' => TRUE,
      'has_archive' => FALSE,
      'exclude_from_search' => FALSE,
      'publicly_queryable' => TRUE,
      'capability_type' => 'page',
      'show_in_rest' => true,
      'rewrite' => array('with_front' => false, 'slug' => get_rezfusion_option(Options::customListingSlug()) ?: 'vacation-rentals')
    ];
  }

  /**
   * @param $columns
   *
   * @return array
   */
  public function getColumns($columns): array {
    $new_columns = [
      'cb' => '<input type="checkbox" />',
      'title' => __('Title'),
      'beds' => __('Beds'),
      'baths' => __('Baths'),
    ];

    foreach($columns as $key => $value) {
      if(strpos($key, 'taxonomy-') === 0) {
        $new_columns[$key] = $value;
      }
    }

    $new_columns['item_id'] = __('Item ID');
    $new_columns[static::floorPlanColumnName()] = __('Custom Floor Plan URL');
    $new_columns['date'] = __('Date');

    return $new_columns;
  }

  /**
   * @param $column
   * @param $post_id
   *
   * @return mixed|void
   */
  public function getColumnContents($column, $post_id ) {
    $meta = get_post_meta($post_id);
    switch($column) {
      case 'beds':
        print $meta[Metas::beds()][0];
        break;
      case 'baths':
        print $meta[Metas::baths()][0];
        break;
      case 'item_id':
        print $meta[Metas::itemId()][0];
        break;
      case static::floorPlanColumnName():
        print !empty($meta[Metas::postFloorPlanURL()][0]) ? '&#10004;' : '';
        break;
    }
  }

  /**
   * Register post meta.
   */
  public function registerMetaFields() {
    register_meta('post', Metas::itemId(), [
      'show_in_rest' => true,
      'single' => true,
      'type' => 'string',
      'object_subtype' => PostTypes::listing()
    ]);
    register_meta('post', Metas::beds(), [
      'show_in_rest' => true,
      'single' => true,
      'type' => 'string',
      'object_subtype' => PostTypes::listing()
    ]);
    register_meta('post', Metas::baths(), [
      'show_in_rest' => true,
      'single' => true,
      'type' => 'string',
      'object_subtype' => PostTypes::listing()
    ]);
  }

  public function addIconPicker($taxonomy) {
    $icons = $this->icon_picker_options;
    ?>
    <div class="form-field term-icon-picker">
      <label for="term-icon">Icon</label>
      <select name="term-icon-picker" id="term-icon" class="postform" style="font-family: 'FontAwesome', system-ui, sans-serif">
      <option value="-1">none</option>
      <?php foreach ($icons as $key => $value) : ?>
      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
      <?php endforeach; ?>
      </select>
      <p class="description">Select an icon to display if this category is set to featured</p>
    </div>
    <?php
  }

  public function saveIconPicker($term_id, $tt_id) {
    if (isset($_POST['term-icon-picker']) && !empty($_POST['term-icon-picker'])) {
      $icon = $_POST['term-icon-picker'];
      add_term_meta( $term_id, 'icon', $icon, false);
    }
  }

  public function editIconPicker($term, $taxonomy) {
    $icons = $this->icon_picker_options;
    $current_icon = get_term_meta( $term->term_id, 'icon', true );
    ?>
    <tr class="form-field term-icon-picker-wrap">
      <th scope="row"><label for="term-icon">Icon</label></th>
      <td>
      <select name="term-icon-picker" id="term-icon" class="postform" style="font-family: 'FontAwesome', system-ui, sans-serif">
      <option value="-1">none</option>
      <?php foreach ($icons as $key => $value) : ?>
      <option value="<?php echo $key; ?>" <?php selected($current_icon, $key); ?>><?php echo $value; ?></option>
      <?php endforeach; ?>
      </select>
      <p class="description">Select an icon to display if this category is set to featured</p>
      </td>
    </tr>
    <?php
  }

  public function updateIconPicker($term_id, $tt_id) {
    if (isset( $_POST['term-icon-picker']) && !empty($_POST['term-icon-picker'])) {
      $icon = $_POST['term-icon-picker'];
      update_term_meta( $term_id, 'icon', $icon );
    }
  }
}
