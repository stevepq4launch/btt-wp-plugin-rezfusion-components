<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Options;

class Favorites extends Shortcode {
  protected $shortcode = 'rezfusion-favorites';

  public function render($atts = []): string {
    $a = shortcode_atts([
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'mapApiKey' => get_rezfusion_option(Options::mapAPI_Key()),
      'endPoint' => get_rezfusion_option(Options::blueprintURL()),
    ], $atts);

    $favoritesEnabled = get_rezfusion_option(Options::enableFavorites());
    $favoritesChannel = $a['channel'];
    $favoritesApiKey = $a['mapApiKey'];
    $favoritesEndPoint = $a['endPoint'];

    add_action( 'wp_footer', function () use ($favoritesApiKey, $favoritesChannel, $favoritesEnabled, $favoritesEndPoint){ ?>
      <script>REZFUSION_COMPONENTS_CONF = { "settings": { "favorites": { "enable": <?php print json_encode($favoritesEnabled); ?> }, "components": { "SearchProvider":{ "channels": <?php print json_encode($favoritesChannel); ?>, "endpoint": <?php print json_encode($favoritesEndPoint) ?>, }, "Map":{ "id": "result-map", "apiKey": <?php print json_encode($favoritesApiKey); ?> } } }};</script>
    <?php });

    return $this->template->render();
  }
}
