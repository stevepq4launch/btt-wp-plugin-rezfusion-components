<?php
/**
 * @file - Provide a shortcode for displaying the availpicker component.
 */
namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class LodgingItemAvailPicker extends Shortcode {
  protected $shortcode = 'rezfusion-item-avail-picker';

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

    $themeUrl = get_option('rezfusion_hub_theme');
    if ($themeUrl) {
      wp_enqueue_style('rezfusion_hub_theme', $themeUrl);
    }

    $client = Plugin::apiClient();
    $result = $client->getItem($a['itemid'], $a['channel']);

    return $this->template->render([
      'lodgingItem' => $result->data->lodgingProducts->results[0],
      'channel' => $a['channel'],
      'sps_domain' => get_option('rezfusion_hub_sps_domain', 'https://checkout.rezfusion.com'),
      'endpoint' => Plugin::blueprint(),
      'conf_page' => get_option('rezfusion_hub_conf_page', ''),
    ]);
  }
}
