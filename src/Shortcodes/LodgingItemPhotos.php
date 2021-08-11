<?php
/**
 * @file - Provide a blank canvas for rendering a photo gallery.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class LodgingItemPhotos extends Shortcode {
  protected $shortcode = 'rezfusion-item-photos';

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

    wp_enqueue_style('rezfusion-photos', plugins_url('rezfusion-components/node_modules/@propertybrands/photos/dist/app.css'));

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]);
  }
}