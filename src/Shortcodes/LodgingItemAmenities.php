<?php

/**
 * @file - Display global policies set in configuration page.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;

class LodgingItemAmenities extends Shortcode {
  protected $shortcode = 'rezfusion-item-amenities';

  /**
   * @param array $atts
   * 
   * @return string
   */

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
    ], $atts);

    return $this->template->render();
  }
}