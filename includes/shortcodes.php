<?php
/**
 * @file - Provide shortcodes for rendering pieces of the UI.
 */

/**
 * Add a shortcode wrapper to download rezfusion components.
 *
 * @param $atts
 *
 * @return string
 */
function rezfusion_component( $atts ) {

  $a = shortcode_atts([
    'element' => 'search',
    'id' => 'app',
    'channel' => get_option('rezfusion_hub_channel'),
    'url' => get_option('rezfusion_hub_folder'),
  ], $atts );

  if(!$a['channel'] || !$a['url']) {
    return "Rezfusion Component: A 'channel' and a 'URL' attribute are both required";
  }

  $handle = "{$a['channel']}-{$a['element']}";

  wp_enqueue_script(
    $handle,
    $a['url']
  );

  if($a['element'] === 'details-page' && $post = get_post()) {
    $meta = get_post_meta($post->ID);
    if($meta['rezfusion_hub_item_id']) {
      wp_localize_script(
        $handle,
        'REZFUSION_COMPONENTS_CONF',
        [
          'settings' => [
            'components' => [
              'DetailsPage' => [
                'id' => $meta['rezfusion_hub_item_id'][0],
              ],
            ],
          ],
        ]
      );
    }
  }

  if(is_tax()) {
    $object = get_queried_object();
    $meta = get_term_meta($object->term_id);
    wp_localize_script(
      $handle,
      'REZFUSION_COMPONENTS_CONF',
      [
        'settings' => [
          'components' => [
            'SearchProvider' => [
              'filters' => [
                'categoryFilter' => [
                  'categories' => [
                    [
                      'cat_id' => $meta['rezfusion_hub_category_id'][0],
                      'values' => $meta['rezfusion_hub_category_value_id'],
                      'operator' => 'AND',
                    ],
                  ],
                ],
              ],
            ],
          ],
        ],
      ]
    );
  }

  return "<div id={$a['id']}></div>";
}

add_shortcode( 'rezfusion-component', 'rezfusion_component' );

/**
 * Provide a shortcode for server rendering an API item.
 *
 * @param $atts
 *
 * @return string
 */
function rezfusion_lodging_item( $atts ) {
  $a = shortcode_atts([
    'channel' => get_option('rezfusion_hub_channel'),
    'itemid' => $atts['itemid']
  ], $atts );

  if(!$a['itemid'] || !$a['channel']) {
    return "Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required";
  }

  $result = rezfusion_components_get_item_details($a['channel'], $a['itemid']);

  return rezfusion_components_render_template(
    'vr-details-page.php',
    __DIR__ . "/../templates",
    [
      'categoryInfo' => $result->data->categoryInfo,
      'lodgingItem' => $result->data->lodgingProducts->results[0]
    ]
  );
}

add_shortcode( 'rezfusion-lodging-item', 'rezfusion_lodging_item' );

/**
 * Provide a shortcode for rendering the favorites flag.
 *
 * @param $atts
 *
 * @return string
 */
function rezfusion_favorites_item( $atts ) {
  $a = shortcode_atts([
    'namespace' => get_option('rezfusion_hub_favorites_namespace', 'rezfusion-favorites'),
    'itemid' => $atts['itemid']
  ], $atts );

  wp_enqueue_script(
    'rezfusion_components_flag',
    plugins_url('rezfusion-components/js/flags.js')
  );

  wp_enqueue_style(
    'rezfusion_components_flag',
    plugins_url('rezfusion-components/css/favorites.css')
  );

  return rezfusion_components_render_template(
    'vr-item-flag.php',
    __DIR__ . "/../templates",
    $a
  );
}

add_shortcode( 'rezfusion-item-flag', 'rezfusion_favorites_item' );

