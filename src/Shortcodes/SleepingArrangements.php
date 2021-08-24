<?php

namespace Rezfusion\Shortcodes;


use Rezfusion\Plugin;

class SleepingArrangements extends Shortcode {
  protected $shortcode = 'rezfusion-sleeping-arrangements';

  public function render($atts = []): string
  {
    $a = shortcode_atts([
      'rooms' => $atts['rooms'],
    ], $atts);
    return $this->template->render([
      'rooms' => $a['rooms'],
    ]);
  }
}
