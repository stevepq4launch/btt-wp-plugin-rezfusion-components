<?php


/**
 * Adds RezFusion Components theme support to any active WordPress theme
 *
 * @since 2.0.0 bbPress (r3032)
 *
 * @param string $slug
 * @param string $name Optional. Default null
 */
function rzf_components_get_template_part( $slug, $name = null ) {

  // Execute code for this part
  do_action( 'get_template_part_' . $slug, $slug, $name );

  // Setup possible parts
  $templates = array();
  if ( isset( $name ) ) {
    $templates[] = $slug . '-' . $name . '.php';
  }
  $templates[] = $slug . '.php';

  // Allow template parst to be filtered
  $templates = apply_filters( 'bbp_get_template_part', $templates, $slug, $name );

  // Return the part that is found
  return rzf_components_locate_template( $templates, true, false );
}

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * Searches in the child theme before parent theme so that themes which
 * inherit from a parent theme can just overload one file. If the template is
 * not found in either of those, it looks in the theme-compat folder last.
 *
 * @since 2.1.0 bbPress (r3618)
 *
 * @param string|array $template_names Template file(s) to search for, in order.
 * @param bool $load If true the template file will be loaded if it is found.
 * @param bool $require_once Whether to require_once or require. Default true.
 *                            Has no effect if $load is false.
 * @return string The template filename if one is located.
 */
function rzf_components_locate_template( $template_names, $load = false, $require_once = true ) {

  // No file found yet
  $located            = false;
  $template_locations = rzf_components_template_stack();

  // Try to find a template file
  foreach ( (array) $template_names as $template_name ) {

    // Continue if template is empty
    if ( empty( $template_name ) ) {
      continue;
    }

    // Trim off any slashes from the template name
    $template_name  = ltrim( $template_name, '/' );

    // Loop through template stack
    foreach ( (array) $template_locations as $template_location ) {

      // Continue if $template_location is empty
      if ( empty( $template_location ) ) {
        continue;
      }

      // Check child theme first
      if ( file_exists( trailingslashit( $template_location ) . $template_name ) ) {
        $located = trailingslashit( $template_location ) . $template_name;
        break 2;
      }
    }
  }

  /**
   * This action exists only to follow the standard RezFusion Components coding convention,
   * and should not be used to short-circuit any part of the template locator.
   *
   * If you want to override a specific template part, please either filter
   * 'rzf_components_get_template_part' or add a new location to the template stack.
   */
  do_action( 'rzf_components_locate_template', $located, $template_name, $template_names, $template_locations, $load, $require_once );

  // Maybe load the template if one was located
  if ( ( defined( 'WP_USE_THEMES' ) && WP_USE_THEMES ) && ( true === $load ) && ! empty( $located ) ) {
    load_template( $located, $require_once );
  }

  return $located;
}

/**
 * Call the functions added to the 'rzf_components_template_stack' filter hook, and return
 * an array of the template locations.
 *
 * @global array $wp_filter Stores all of the filters
 * @global array $merged_filters Merges the filter hooks using this function.
 * @global array $wp_current_filter stores the list of current filters with the current one last
 *
 * @return array The filtered value after all hooked functions are applied to it.
 */
function rzf_components_get_template_stack() {
  global $wp_filter, $merged_filters, $wp_current_filter;

  // Setup some default variables
  $tag  = 'rzf_components_template_stack';
  $args = $stack = array();

  // Add 'bbp_template_stack' to the current filter array
  $wp_current_filter[] = $tag;

  // Bail if no stack setup
  if ( empty( $wp_filter[ $tag ] ) ) {
    return array();
  }

  // Check if WP_Hook class exists, see #WP17817
  if ( class_exists( 'WP_Hook' ) ) {
    $filter = $wp_filter[ $tag ]->callbacks;
  } else {
    $filter = &$wp_filter[ $tag ];

    // Sort
    if ( ! isset( $merged_filters[ $tag ] ) ) {
      ksort( $filter );
      $merged_filters[ $tag ] = true;
    }
  }

  // Ensure we're always at the beginning of the filter array
  reset( $filter );

  // Loop through 'bbp_template_stack' filters, and call callback functions
  do {
    foreach ( (array) current( $filter ) as $the_ ) {
      if ( ! is_null( $the_['function'] ) ) {
        $args[1] = $stack;
        $stack[] = call_user_func_array( $the_['function'], array_slice( $args, 1, (int) $the_['accepted_args'] ) );
      }
    }
  } while ( next( $filter ) !== false );

  // Remove 'bbp_template_stack' from the current filter array
  array_pop( $wp_current_filter );

  // Remove empties and duplicates
  $stack = array_unique( array_filter( $stack ) );

  // Filter & return
  return (array) apply_filters( 'rzf_components_get_template_stack', $stack ) ;
}


/**
 * This is really cool. This function registers a new template stack location,
 * using WordPress's built in filters API.
 *
 * This allows for templates to live in places beyond just the parent/child
 * relationship, to allow for custom template locations. Used in conjunction
 * with rzf_components_locate_template(), this allows for easy template overrides.
 *
 * @param string $location_callback Callback function that returns the
 * @param int $priority
 */
function rzf_components_register_template_stack( $location_callback = '', $priority = 10 ) {

  // Bail if no location, or function/method is not callable
  if ( empty( $location_callback ) || ! is_callable( $location_callback ) ) {
    return false;
  }

  // Add location callback to template stack
  return add_filter( 'rzf_components_template_stack', $location_callback, (int) $priority );
}
