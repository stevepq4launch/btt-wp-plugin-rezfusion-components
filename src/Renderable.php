<?php
/**
 * @file - Provide an interface to describe a class can be rendered.
 */
namespace Rezfusion;

interface Renderable {

  /**
   * A typical render function will handle output buffering and extraction
   * of variables.
   *
   * @param array $variables
   *
   * @return string
   */
  public function render($variables = []): string;

}
