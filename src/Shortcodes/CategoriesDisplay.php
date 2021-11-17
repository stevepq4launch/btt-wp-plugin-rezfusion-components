<?php

/**
 * @file - Shortcode for categories display component.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Plugin;

class CategoriesDisplay extends Shortcode {
  protected $shortcode = 'rezfusion-categories-display';

  /**
   * @param array $atts
   *
   * @return string
   */

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemid' => $atts['itemid'],
    ], $atts);

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'channel' => $a['channel'],
      'lodgingItem' => $result->data->lodgingProducts->results[0],
      'sps_domain' => get_rezfusion_option(Options::SPS_Domain()),
      'endpoint' => get_rezfusion_option(Options::blueprintURL()),
      'conf_page' => get_rezfusion_option(Options::bookingConfirmationURL(), '')
    ]);
    return $this->template->render();
  }
}
