<?php
namespace Rezfusion\Metaboxes;

/**
 * A WordPress meta box that appears in the editor.
 */
class Metabox {

  /**
   * Screen context where the meta box should display.
   *
   * @var string
   */
  private $context;

  /**
   * The ID of the meta box.
   *
   * @var string
   */
  private $id;

  /**
   * The display priority of the meta box.
   *
   * @var string
   */
  private $priority;

  /**
   * Screens where this meta box will appear.
   *
   * @var string[]
   */
  private $screens;

  /**
   * Path to the template used to display the content of the meta box.
   *
   * @var \Rezfusion\Template
   */
  private $template;

  /**
   * The title of the meta box.
   *
   * @var string
   */
  private $title;

  /**
   * Metabox constructor.
   *
   * @param $id
   * @param $template
   * @param $title
   * @param array $screens
   * @param string $context
   * @param string $priority
   */
  public function __construct($id, $template, $title, $screens = [], $priority = 'default', $context = 'advanced') {
    if (is_string($screens)) {
      $screens = (array) $screens;
    }

    $this->context = $context;
    $this->id = $id;
    $this->priority = $priority;
    $this->screens = $screens;
    $this->template = $template;
    $this->title = $title;
    add_action('add_meta_boxes', [$this, 'register']);
  }

  /**
   * @param \WP_Post $post
   */
  public function render(\WP_Post $post) {
    $variables = ['post' => $post, 'instance' => $this, 'meta' => get_post_meta($post->ID)];
    print $this->template->render($variables);
  }

  /**
   * Get the screen context where the meta box should display.
   *
   * @return string
   */
  public function getContext() {
    return $this->context;
  }

  /**
   * Get the ID of the meta box.
   *
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the display priority of the meta box.
   *
   * @return string
   */
  public function getPriority() {
    return $this->priority;
  }

  /**
   * Get the screen(s) where the meta box will appear.
   *
   * @return array|string|\WP_Screen
   */
  public function getScreens() {
    return $this->screens;
  }

  /**
   * Get the title of the meta box.
   *
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Register the metabox with WordPress.
   */
  public function register() {
    add_meta_box($this->getId(), $this->getTitle(), [$this, 'render'], $this->getScreens(), $this->getContext(), $this->getPriority());
  }
}
