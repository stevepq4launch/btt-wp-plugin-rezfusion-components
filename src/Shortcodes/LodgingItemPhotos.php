<?php
/**
 * @file - Provide a blank canvas for rendering a photo gallery.
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;
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
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'itemid' => $atts['itemid']
    ], $atts );

    if(!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    $Registerer = Plugin::getInstance()->getRegisterer();
    $Registerer->handleScript('slideshow.js');
    $Registerer->handleStyle('slideshow.css');

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]);
  }
}
