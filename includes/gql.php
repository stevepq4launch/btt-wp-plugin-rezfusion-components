<?php
/**
 * @file - Query for data from blueprint.
 */

/**
 * Make an HTTP request to get item data.
 *
 * @todo: This needs to be able to pass a param for "updated_ts"
 * @todo: ^^ Blueprint needs to support that, too.
 *
 * @param $channel
 *
 * @return array|mixed|object
 */
function rezfusion_components_get_items($channel) {
  $query = <<<'JSON'
query($channels:ChannelFilter!) {
  lodgingProducts(channels:$channels) {
    results {
      beds
      baths
      item {
        id
        name
        category_values {
          value {
            name
            id
          }
        }
      }
    }
  }
}
JSON;

  $variables = [
    'channels' => [
      'url' => $channel,
    ]
  ];

  $json = json_encode(['query' => $query, 'variables' => $variables]);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, rezfusion_components_get_blueprint_url());
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json;charset=utf-8',
    ]
  );

  $response = curl_exec($ch);
  return json_decode($response);
}


/**
 * Make an HTTP request to get category data.
 *
 * @param $channel
 *
 * @return array|mixed|object
 */
function rezfusion_components_get_categories($channel) {
  $query = <<<'JSON'
query($channels:ChannelFilter!) {
  categoryInfo(channels:$channels) {
    categories {
      name
      id
      values {
        name
        id
      }
    }
  }
}
JSON;

  $variables = [
    'channels' => [
      'url' => $channel,
    ]
  ];

  $json = json_encode(['query' => $query, 'variables' => $variables]);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, rezfusion_components_get_blueprint_url());
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json;charset=utf-8',
    ]
  );

  $response = curl_exec($ch);
  return json_decode($response);
}

/**
 * Update item data.
 *
 * This function runs on save of the form.
 *
 * @param null $channel
 *
 * @return bool
 */
function rezfusion_components_cache_item_data($channel = NULL) {
  if(!$channel) {
    $channel = get_option('rezfusion_hub_channel');
  }

  $data = rezfusion_components_get_items($channel);

  if(!empty($data)) {
    set_transient('rezfusion_hub_item_data', $data);
    return TRUE;
  }

  return FALSE;
}

/**
 * Update item data.
 *
 * This function runs on save of the form.
 *
 * @param null $channel
 *
 * @return bool
 */
function rezfusion_components_cache_category_data($channel = NULL) {
  if(!$channel) {
    $channel = get_option('rezfusion_hub_channel');
  }

  $data = rezfusion_components_get_categories($channel);

  if(!empty($data)) {
    set_transient('rezfusion_hub_category_data', $data);
    return TRUE;
  }

  return FALSE;
}

/**
 * Perform an update of location post data. This function
 * is meant to be run a couple times a day to update
 * data.
 *
 * @param null $channel
 */
function rezfusion_components_update_item_data($channel = NULL) {
  // Update category data first. Ensures we have all the
  // latest taxonomy terms.
  rezfusion_components_update_category_data();
  // Warm the cache, and get the items from there.
  rezfusion_components_cache_item_data($channel);
  $items = get_transient('rezfusion_hub_item_data');

  // By default we will sync into the `vr_listing` post type.
  $post_type = get_option('rezfusion_hub_sync_items_post_type', 'vr_listing');

  $args = [
    'post_type' => [$post_type],
    'nopaging' => TRUE,
  ];

  $query = new WP_Query($args);
  // Rekey the array by ID.
  $local_items = array_reduce($query->posts, function($carry, $item) {
    if(!empty($item->ID)) {
      $meta = get_post_meta($item->ID);
      if(isset($meta['rezfusion_hub_item_id'][0])) {
        $carry[$meta['rezfusion_hub_item_id'][0]] = $item;
      }
    }
    return $carry;
  }, []);

  if (isset($items->data->lodgingProducts->results) && !empty($items->data->lodgingProducts->results)) {
    foreach($items->data->lodgingProducts->results as $result) {
      $id = $result->item->id;
      $data = [
        'post_type' => $post_type,
        'post_status' => 'publish',
        'post_title' => $result->item->name,
        'meta_input' => [
          'rezfusion_hub_item_id' => $result->item->id,
          'rezfusion_hub_beds' => $result->beds,
          'rezfusion_hub_baths' => $result->baths,
        ],
      ];
      if(!empty($local_items[$id])) {
        $post_id = wp_update_post([
          'ID' => $local_items[$id]->ID,
        ] + $data);
        // Remove from the list. This'll
        // let us know which items
        // need to unpublished.
        unset($local_items[$id]);
      }
      else {
        $post_id = wp_insert_post($data);
      }

      // Add tags to items.
      rezfusion_components_process_item_categories($result->item, $post_id);
    }

    // These are missing from Blueprint.
    // So unpublish them.
    if(!empty($local_items)) {
      $data = [
        'post_status' => 'draft',
      ];
      foreach($local_items as $local_item) {
        wp_update_post([
            'ID' => $local_item->ID,
          ] + $data);
      }
    }
  }
}

/**
 * Process the currently flagged items and add new ones for an item.
 *
 * @param $api_item
 * @param $post int
 */
function rezfusion_components_process_item_categories($api_item, $post) {
  if (empty($api_item->category_values)) {
    return;
  }

  $values = array_map(function($value) {
    return $value->value->id;
  }, $api_item->category_values);

  $args = [
    'hide_empty' => FALSE,
    'fields' => 'all',
    'count' => TRUE,
    'meta_query' => [
      [
        'key' => 'rezfusion_hub_category_value_id',
        'value' => $values,
        'compare' => 'IN',
      ],
    ],
  ];

  $taxonomies = [];
  $query = new WP_Term_Query($args);
  if(!empty($query->terms)) {
    $taxonomies = array_reduce($query->terms, function($carry, $item) {
      if(!isset($carry[$item->taxonomy])) {
        $carry[$item->taxonomy] = [$item->term_id];
      }
      else {
        $carry[$item->taxonomy][] = $item->term_id;
      }
      return $carry;
    }, []);
  }

  foreach($taxonomies as $taxonomy => $term_ids) {
    wp_set_post_terms($post, $term_ids, $taxonomy);
  }
}

/**
 * Sync term data.
 *
 * This function only downloads cateogry data from blueprint, and stores
 * the taxonomies/terms in WordPress. `rezfusion_components_process_item_categories()`
 * is responsible for setting terms on a post.
 *
 * @param null $channel
 */
function rezfusion_components_update_category_data($channel = NULL) {
  // Warm the cache, and get the items from there.
  rezfusion_components_cache_item_data($channel);
  $categories = get_transient('rezfusion_hub_category_data');
  $taxonomies = [];
  $category_values = [];
  if (isset($categories->data->categoryInfo->categories) && !empty($categories->data->categoryInfo->categories)) {
    foreach($categories->data->categoryInfo->categories as $category) {
      $name = str_replace('-', '_', sanitize_title($category->name));
      $taxonomies[] = $name;
      if(!empty($category->values)) {
        foreach($category->values as $value) {
          $value->wp_taxonomy_name = $name;
          $category_values[$value->id] = $value;
        }
      }
    }
  }

  if(empty($taxonomies) || empty($category_values)) {
    return;
  }

  $args = [
    'taxonomy' => $taxonomies,
    'hide_empty' => FALSE,
    'fields' => 'all',
    'count' => TRUE,
  ];

  $terms = [];
  $query = new WP_Term_Query($args);
  if(!empty($query->terms)) {
    $terms = array_reduce($query->terms, function($carry, $item) {
      if(!empty($item->term_id)) {
        $meta = get_term_meta($item->term_id);
        if(isset($meta['rezfusion_hub_category_value_id'][0])) {
          $carry[$meta['rezfusion_hub_category_value_id'][0]] = $item;
        }
      }
      return $carry;
    }, []);
  }

  $to_create = array_diff_key($category_values, $terms);

  foreach($to_create as $value) {
    $term = wp_insert_term($value->name, $value->wp_taxonomy_name);
    add_term_meta(
      $term['term_id'],
      'rezfusion_hub_category_value_id',
      $value->id,
      true
    );
  }

}