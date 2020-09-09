<?php
/**
 * @file - Provide a shortcode for displaying the availcalendar component.
 */
namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class LodgingItemAvailCalendar extends Shortcode {
  protected $shortcode = 'rezfusion-item-avail-calendar';

  /**
   * @param array $atts
   *
   * @return string
   * @throws \Exception
   */
  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_option('rezfusion_hub_channel'),
      'itemid' => $atts['itemid'],
    ], $atts );

    if(!$a['itemid'] || !$a['channel']) {
      return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0],
    ]);
  }
}
