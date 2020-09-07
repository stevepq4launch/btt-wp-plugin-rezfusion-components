<?php
/**
 * @file - Provide a shortcode implementation.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Renderable;
use Rezfusion\Template;

abstract class Shortcode implements Renderable {

  /**
   * The shortcode tag to use
   *
   * @var string
   */
  protected $shortcode;

  /**
   * @var Template
   */
  protected $template;

  /**
   * Shortcode constructor.
   *
   * @param \Rezfusion\Template $template
   *
   * @throws \Exception
   */
  public function __construct(Template $template) {
    $this->template = $template;
    if(!$this->shortcode) {
      $class = __CLASS__;
      throw new \Exception("Invalid shortcode in {$class}");
    }
    add_shortcode($this->shortcode, [$this, 'render']);
  }

  /**
   * @param array $shortcodeAtts
   *
   * @return string
   */
  abstract public function render($shortcodeAtts = []): string;

}
