<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Plugin;

class Search extends Shortcode
{

  protected $shortcode = 'rezfusion-search';

  public function render($atts = []): string
  {
    $atts = shortcode_atts([
      'channel' => get_option('rezfusion_hub_channel'),
      'bundleUrl' => get_option('rezfusion_hub_folder'),
      'endpoint' => Plugin::blueprint(),
      'mapApiKey' => get_option('rezfusion_hub_google_maps_api_key'),
      'favoritesEnabled' => isset(get_option('rezfusion_hub_enable_favorites')['1']) ? true : false,
      'spsDomain' => get_option('rezfusion_hub_sps_domain'),
    ], $atts);

    $errorMessages = '';
    if (!$atts['channel']) {
      $errorMessages .= "<p>Rezfusion Search Component: Channel Domain/URL setting is required.</p>";
    }
    if (!$atts['bundleUrl']) {
      $errorMessages .= "<p>Rezfusion Search Component: Components URL setting is required</p>";
    }
    if (!$atts['endpoint']) {
      $errorMessages .= "<p>Rezfusion Search Component: Blueprint endpoint not found.</p>";
    }
    if (!$atts['spsDomain']) {
      $errorMessages .= "<p>Rezfusion Search Component: SPS Domain setting is required.</p>";
    }

    if ($errorMessages) {
      return $errorMessages;
    }

    $trimmedBundle = NULL;
    $fontUrl = NULL;
    $bundle = file($atts['bundleUrl'], FILE_SKIP_EMPTY_LINES);
    foreach ($bundle as $key => $value) {
      preg_match('~^.*REZFUSION_COMPONENTS_BUNDLE_CONF.*~', $value, $c);
      preg_match('~href = \'(https://fonts\.googleapis.*)\';~', $value, $f);
      if ( !empty( $c ) ) {
        $trimmedBundle .= $c[0];
      }
      if ( !empty( $f ) ) {
        $fontUrl .= $f[1];
      }
    }

    $configJson = array(
      "settings" => [
        "favorites" => [
          "enable" => $atts['favoritesEnabled'],
        ],
        "components" => [
          "SearchProvider" => [
            "channels" => $atts['channel'],
            "endpoint" => $atts['endpoint'],
          ],
          "Map" => [
            "id" => "result-map",
            "apiKey" => $atts['mapApiKey'],
          ],
          "AvailabilitySearchConsumer" => [
            "spsDomain" => $atts['spsDomain'],
          ],
        ],
      ],
    );

    if (is_tax()) {
      $object = get_queried_object();
      $meta = get_term_meta($object->term_id);
      $catFilter = array(
        'cat_id' => $meta['rezfusion_hub_category_id'][0],
        'values' => $meta['rezfusion_hub_category_value_id'],
        'operator' => 'AND',
      );
      $configJson['settings']['components']['SearchProvider']['filters']['categoryFilter']['categories'] = $catFilter;
    }

    if (get_post_type() == 'vr_promo') {
      $promoIds = [];
      foreach (get_post_meta(get_post()->ID, 'rzf_promo_listing_value')[0] as $listing) {
        $meta = get_post_meta($listing);
        $promoIds[] = $meta['rezfusion_hub_item_id'][0];
      }
      $idFilter = array('itemIds' => $promoIds);
      $configJson['settings']['components']['SearchProvider']['filters'] = $idFilter;
    }

    add_action('wp_footer', function () use ($trimmedBundle, $configJson) {
      print "<script>" . $trimmedBundle . "</script>";
      print "<script>REZFUSION_COMPONENTS_CONF = " . json_encode($configJson) . "</script>";
    });

    $themeUrl = get_option('rezfusion_hub_theme');
    if ($themeUrl) {
      wp_enqueue_style('rezfusion_hub_theme', $themeUrl);
    }

    if (!empty($fontUrl)) {
      wp_enqueue_style('rezfusion_hub_font', $fontUrl);
    }

    return $this->template->render($atts);
  }
}