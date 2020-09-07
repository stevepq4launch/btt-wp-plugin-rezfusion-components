<?php
/**
 * @file - Represent a template path. So that we can detect
 * the presence of a template file in the plugin versus
 * in the theme.
 */
namespace Rezfusion;

class Template implements Renderable {

  /**
   * A template (file) name any valid string filename will do.
   *
   * `vr-details.php` for example
   *
   * Will first check themes, then in the plugin directory.
   *
   * @var string
   */
  protected $template;

  /**
   * @var string
   */
  protected $path;

  public function __construct(string $template, string $path = REZFUSION_PLUGIN_TEMPLATES_PATH) {
    $this->template = $template;
    $this->path = $path;
  }

  /**
   * @return string
   */
  protected function getPath(): string {
    return "$this->path/$this->template";
  }

  /**
   * Get the location in the file system.
   *
   * @return string
   */
  public function locateTemplate(): string {
    if($located = locate_template($this->template)) {
      return $located;
    }
    return $this->getPath();
  }

  /**
   * Render a template by performing output buffering.
   *
   * @param array $variables
   *
   * @return string
   */
  public function render($variables = []): string {
    $variables = apply_filters("variables_{$this->locateTemplate()}", $variables);
    extract($variables);
    ob_start();
    require_once($this->locateTemplate());
    return ob_get_clean();
  }
}
