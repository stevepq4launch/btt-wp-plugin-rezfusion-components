<?php

use Rezfusion\Partial;
use Rezfusion\Templates;

/**
 * Render opening HTML part of modal component.
 *
 * @param string $modalId
 *
 * @return string
 */
function rezfusion_modal_open($modalId = ''): string
{
  return (new Partial(Templates::modalOpenPartial()))->render(['modalId' => $modalId]);
}

/**
 * Render closing HTML part of modal component.
 *
 * @return string
 */
function rezfusion_modal_close(): string
{
  return (new Partial(Templates::modalClosePartial()))->render([]);
}

/**
 * Custom template loader function. This function will search
 * custom theme directories for a given template and, if not found, will fallback to the Plugin-defined
 * default template.
 *
 * @param $template_name
 * @return void
 */
function rezfusion_load_template($template_name) {
  $template_name = ltrim( $template_name, '/' );
  // Look for this template in a child theme, first.
  $template_path = locate_template( 'rezfusion-components/' . $template_name);

  // Fallback to our default plugin template.
  if (!$template_path) {
    $plugin_dir = plugin_dir_path(dirname( __FILE__ ));
    $template_path = $plugin_dir . 'templates/' . $template_name;
  }

  // Load the actual template.
  load_template($template_path);
}
