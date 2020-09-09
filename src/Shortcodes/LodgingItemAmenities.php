<?php

/**
 * @file - Display global policies set in configuration page.
 */

namespace Rezfusion\Shortcodes;

class LodgingItemAmenities extends Shortcode {
  protected $shortcode = 'rezfusion-item-amenities';

  /**
   * @param array $atts
   * 
   * @return string
   */

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_option('rezfusion_hub_channel'),
    ], $atts);

    return $this->template->render();
  }
}