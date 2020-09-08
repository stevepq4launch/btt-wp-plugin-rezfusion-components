<?php
/**
 * @file - Provide a common interface for classes to implement.
 */
namespace Rezfusion\PostTypes;

abstract class PostType {

  protected $postTypeName;

  public function __construct($postTypeName) {
    $this->postTypeName = $postTypeName;
    add_action('init', [$this, 'register']);
    add_filter("manage_{$this->postTypeName}_posts_columns", [$this, 'getColumns']);
    add_action( "manage_{$this->postTypeName}_posts_custom_column", [$this, 'getColumnContents'], 10, 2);
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
