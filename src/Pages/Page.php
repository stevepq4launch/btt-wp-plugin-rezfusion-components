<?php

/**
 * @file - Render a page.
 */

namespace Rezfusion\Pages;

use Rezfusion\Template;

abstract class Page
{

  /**
   * @var string
   */
  const PAGE_NAME = '';

  protected $template;

  /**
   * Page constructor.
   *
   * Provide a template to use which the display function will
   * render for us.
   *
   * @param \Rezfusion\Template $template
   */
  public function __construct(Template $template)
  {
    $this->template = $template;
  }

  /**
   * Handle the display of an individual page.
   *
   * @return mixed
   */
  abstract public function display();

  /**
   * @return string
   */
  public static function pageName()
  {
    return static::PAGE_NAME;
  }
}
