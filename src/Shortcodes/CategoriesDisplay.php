<?php

/**
 * @file - Shortcode for categories display component.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;

class CategoriesDisplay extends Shortcode {
  protected $shortcode = 'rezfusion-categories-display';

  /**
   * @param array $atts
   *
   * @return string
   */

  public function render($atts = []): string {
    print_r(get_option('rezfusion_hub_amenities_general'));
    // $a = shortcode_atts([
    //   'categories' => get_rezfusion_option(Options::hubChannelURL()),
    // ], $atts);

    return $this->template->render();
  }
}
