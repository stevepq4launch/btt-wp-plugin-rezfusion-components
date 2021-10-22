<?php
/**
 * @file - Provide a common interface for classes to implement.
 */
namespace Rezfusion\PostTypes;

use Rezfusion\Actions;
use Rezfusion\Filters;

abstract class PostType {

  protected $postTypeName;
  
  public $icon_picker_options;

  public function __construct($postTypeName) {
    $this->postTypeName = $postTypeName;
    add_action(Actions::init(), [$this, 'register']);
    add_filter(Filters::managePostTypePostsColumns($this->postTypeName), [$this, 'getColumns']);
    add_action(Actions::managePostTypePostsCustomColumn($this->postTypeName), [$this, 'getColumnContents'], 10, 2);
    $this->icon_picker_options = include plugin_dir_path( __FILE__ ) . 'IconArray.php'; 
  }

  /**
   * Provide a common AP for getting the post type
   * name.
   *
   * @return mixed
   */
  public function getPostTypeName() {
    return $this->postTypeName;
  }

  /**
   * WordPress core post type label definition.
   *
   * @return array
   */
  abstract public function getLabels(): array;

  /**
   * WordPress core post type definition.
   *
   * @return array
   */
  abstract public function getPostTypeDefinition(): array;

  /**
   * Get the list of columns to display in the list of posts.
   *
   * @param $columns
   *
   * @return array
   */
  abstract public function getColumns($columns): array;

  /**
   * Get the contents of the column header.

   * @param $column
   * @param $postId
   *
   * @return mixed
   */
  abstract public function getColumnContents($column, $postId);

  /**
   * @return void
   */
  abstract public function registerTaxonomies();

  /**
   * @return void
   */
  abstract public function registerMetaFields();

  /**
   * Register the post type
   *
   * @return void
   */
  public function register() {
    $this->registerTaxonomies();
    register_post_type($this->getPostTypeName(), $this->getPostTypeDefinition());
    $this->registerMetaFields();
  }
  
}
