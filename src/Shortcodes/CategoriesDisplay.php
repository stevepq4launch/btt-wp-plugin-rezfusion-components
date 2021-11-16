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

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0],
    ]);
    return $this->template->render();
  }
}
