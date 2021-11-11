<?php

/**
 * @file - Display global policies set in configuration page.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;

class LodgingGlobalPolicies extends Shortcode {
  protected $shortcode = 'rezfusion-global-policies';

  /**
   * @param array $atts
   * 
   * @return string
   */

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'collapse' => 0,
    ], $atts);

    if ($a['collapse'] == 1) {
      $collapseFlag = true;
    } else {
      $collapseFlag = false;
    }

    return $this->template->render([
      'collapse' => $collapseFlag
    ]);
  }
}