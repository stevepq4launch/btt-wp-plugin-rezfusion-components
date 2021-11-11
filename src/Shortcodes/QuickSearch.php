<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Options;
use Rezfusion\Plugin;

class QuickSearch extends Shortcode
{

  /**
   * @var string
   */
  const INCLUDE_DETAILS_ATTR_KEY = "details";

  /**
   * @var string
   */
  protected $shortcode = "rezfusion-quick-search";

  /**
   * @param array $atts
   * 
   * @return string
   */
  public function render($atts = []): string
  {
    $containerClass = 'quick-search';
    $containerClassAttribute = 'container-class';
    $atts = shortcode_atts([
      $containerClassAttribute => ''
    ], $atts);

    if (!empty($atts[$containerClassAttribute])) {
      $containerClass .= ' ' . $atts[$containerClassAttribute];
    }

    Plugin::getInstance()->enqueueRezfusionComponentsBundle();

    return $this->template->render([
      'containerId' => 'rezfusion-quicksearch',
      'containerClass' => $containerClass
    ], true);
  }
}
