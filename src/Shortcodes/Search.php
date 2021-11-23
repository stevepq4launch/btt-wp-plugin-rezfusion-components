<?php

namespace Rezfusion\Shortcodes;

use Rezfusion\Helper\PromoCodePropertiesHelper;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;

class Search extends Shortcode
{

  protected $shortcode = 'rezfusion-search';

  public function render($atts = []): string
  {
    $atts = [];
    (new PromoCodePropertiesHelper(Plugin::getInstance()->getAssetsRegisterer(), new ItemRepository(Plugin::apiClient())))->handle($atts);
    return $this->template->render($atts);
  }
}
