<?php



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

  // These are used in the template.
  $categoryInfo = $result->data->categoryInfo;
  $lodgingItem = $result->data->lodgingProducts->results[0];

  unset($result);
  ob_start();

  if($located = locate_template('vr-details-page.php')) {
    require_once ($located);
  }
  else {
    require_once (__DIR__ . "/../templates/vr-details-page.php");
  }
  return ob_get_clean();
}

add_shortcode( 'rezfusion-lodging-item', 'rezfusion_lodging_item' );
