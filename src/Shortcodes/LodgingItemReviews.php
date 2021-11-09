<?php
/**
 * @file - Provide a list of reviews that co mingle API reviews and
 * user provided reviews.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Plugin;

class LodgingItemReviews extends Shortcode {
  protected $shortcode = 'rezfusion-item-reviews';

  /**
   * @param array $atts
   *
   * @return string
   * @throws \Exception
   */
  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemid' => $atts['itemid']
    ], $atts );

    if(!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    /**
     * @todo: Extract reviews from API
     * @todo: Load reviews in DB
     * @todo: Merge reviews and sort by date desc.
     */

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]);
  }
}
