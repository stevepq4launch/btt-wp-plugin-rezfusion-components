<?php
/**
 * @file - Render a favorites flag fit for a single item display.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Assets;
use Rezfusion\Options;
use Rezfusion\Plugin;

class ItemFlag extends Shortcode {

  protected $shortcode = 'rezfusion-item-flag';

  public function render($atts = []): string {
    $a = shortcode_atts([
      'namespace' => get_rezfusion_option(Options::favoritesNamespace(), 'rezfusion-favorites'),
      'itemid' => $atts['itemid']
    ], $atts );

    Plugin::getInstance()->getAssetsRegisterer()->handleStyle(Assets::favoritesStyle());

    return $this->template->render($a);
  }

}
