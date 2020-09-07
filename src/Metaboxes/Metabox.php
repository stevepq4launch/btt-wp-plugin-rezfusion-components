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
   * Constructor.
   *
   * @param string $id
   * @param \Rezfusion\Template $template
   * @param string $title
   * @param string $context
   * @param string $priority
   * @param string[] $screens
   */
  public function __construct($id, $template, $title, $context = 'advanced', $priority = 'default', $screens = []) {
    if (is_string($screens)) {
      $screens = (array) $screens;
    }

    $this->context = $context;
    $this->id = $id;
    $this->priority = $priority;
    $this->screens = $screens;
    $this->template = $template;
    $this->title = $title;
  }

  /**
   * @param \WP_Post $post
   *
   * @return string
   */
  public function getCallback(\WP_Post $post) {
    $variables = ['post' => $post, 'instance' => $this];
    return function() use($variables) { $this->render($this->template, $variables); };
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
}
