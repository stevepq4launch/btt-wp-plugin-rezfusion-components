<?php

/**
 * @file - Provide a common interface for classes to implement.
 */

namespace Rezfusion\PostTypes;

use Rezfusion\Actions;

abstract class PostTypeSimple
{

  protected $postTypeName;

  public function __construct($postTypeName)
  {
    $this->postTypeName = $postTypeName;
    add_action(Actions::init(), [$this, 'register']);
  }

  /**
   * Provide a common AP for getting the post type
   * name.
   *
   * @return mixed
   */
  public function getPostTypeName()
  {
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
   * Add listing checkboxes to promo admin.
   */
  public function addMetaFields()
  {
  }

  /**
   * Generate listing checkboxes.
   */
  public function createListingField()
  {
    global $post;
  }

  /**
   * Register the post type
   *
   * @return void
   */
  public function register()
  {
    register_post_type($this->getPostTypeName(), $this->getPostTypeDefinition());
  }
}