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
    // get_rezfusion_option(Options::hubChannelURL()),
    $a = shortcode_atts([
      'channel' => "https://easternshorevacations.com",
      'itemid' => $atts['itemid'],
    ], $atts);

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    // endpoint: get_rezfusion_option(Options::blueprintURL()),
    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0],
      'sps_domain' => get_rezfusion_option(Options::SPS_Domain()),
      'endpoint' => 'http://host.docker.internal:3000/graphql',
      'conf_page' => get_rezfusion_option(Options::bookingConfirmationURL(), '')
    ]);
    return $this->template->render();
  }
}
