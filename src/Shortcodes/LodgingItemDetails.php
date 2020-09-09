<?php
/**
 * @file - Provide a shortcode for rendering a single item.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class LodgingItemDetails extends Shortcode {

  protected $shortcode = 'rezfusion-lodging-item';

  /**
   * @param array $atts
   *
   * @return string
   * @throws \Exception
   */
  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_option('rezfusion_hub_channel'),
      'itemid' => $atts['itemid']
    ], $atts );

    if(!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'categoryInfo' => $result->data->categoryInfo,
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]);
  }

}
