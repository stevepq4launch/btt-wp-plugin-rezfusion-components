<?php

/**
 * @file - Provide a simple
 */

namespace Rezfusion\Shortcodes;

use Rezfusion\Exception\ComponentsBundleURL_RequiredException;
use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\PostTypes;
use Rezfusion\Registerer\ComponentsBundleRegisterer;

class Component extends Shortcode
{

  protected $shortcode = 'rezfusion-component';

  public function render($atts = []): string
  {
    $a = shortcode_atts([
      'element' => 'search',
      'id' => 'app',
      'channel' => get_rezfusion_option(Options::hubChannelURL()),
      'url' => get_rezfusion_option(Options::componentsURL()),
    ], $atts);

    if (!$a['channel'] || !$a['url']) {
      return "Rezfusion Component: A 'channel' and a 'URL' attribute are both required";
    }

    if (empty($componentsBundleURL = get_rezfusion_option(Options::componentsBundleURL()))) {
      throw new ComponentsBundleURL_RequiredException();
    }

    $handle = $this->AssetsRegisterer->handleScriptURL($componentsBundleURL);

    $favoritesEnabled = get_rezfusion_option(Options::enableFavorites());

    if ($a['element'] == 'search') {
      wp_localize_script(
        $handle,
        ComponentsBundleRegisterer::userDefinedConfigurationVariableName(),
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ]
          ]
        ]
      );
    }

    if ($a['element'] === 'details-page' && $post = get_post()) {
      $meta = get_post_meta($post->ID);
      if ($meta[Metas::itemId()]) {
        wp_localize_script(
          $handle,
          ComponentsBundleRegisterer::userDefinedConfigurationVariableName(),
          [
            'settings' => [
              'components' => [
                'DetailsPage' => [
                  'id' => $meta[Metas::itemId()][0],
                ],
              ],
            ],
          ]
        );
      }
    }

    if (is_tax()) {
      $object = get_queried_object();
      $meta = get_term_meta($object->term_id);
      wp_localize_script(
        $handle,
        ComponentsBundleRegisterer::userDefinedConfigurationVariableName(),
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ],
            'components' => [
              'SearchProvider' => [
                'filters' => [
                  'categoryFilter' => [
                    'categories' => [
                      [
                        'cat_id' => intval($meta[Metas::categoryId()][0]),
                        'values' => array_map(function ($value) {
                          return intval($value);
                        }, $meta[Metas::categoryValueId()]),
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

    if (get_post_type() === PostTypes::promo()) {
      $promoIds = [];
      foreach (get_post_meta(get_post()->ID, Metas::promoListingValue())[0] as $listing) {
        $meta = get_post_meta($listing);
        array_push($promoIds, $meta[Metas::itemId()][0]);
      }
      wp_localize_script(
        $handle,
        ComponentsBundleRegisterer::userDefinedConfigurationVariableName(),
        [
          'settings' => [
            'favorites' => [
              'enable' => $favoritesEnabled
            ],
            'components' => [
              'SearchProvider' => [
                'filters' => [
                  'itemIds' => $promoIds,
                ],
              ],
            ],
          ],
        ]
      );
    }

    return $this->template->render($a);
  }
}
