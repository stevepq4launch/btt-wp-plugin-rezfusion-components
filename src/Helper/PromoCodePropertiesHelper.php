<?php

namespace Rezfusion\Helper;

use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;

class PromoCodePropertiesHelper
{

    /**
     * @var Plugin
     */
    protected $Plugin;

    /**
     * @var ItemRepository
     */
    protected $ItemRepository;

    /**
     * @param Plugin $Plugin
     * @param ItemRepository $ItemRepository
     */
    public function __construct(Plugin $Plugin, ItemRepository $ItemRepository)
    {
        $this->Plugin = $Plugin;
        $this->ItemRepository = $ItemRepository;
    }

    /**
     * @param array $attributes
     */
    public function handle(&$attributes = [])
    {
        wp_enqueue_style('property-card-badge-style', plugin_dir_url(REZFUSION_PLUGIN) . '/assets/css/property-card-flag.css');
        wp_enqueue_script('property-card-badge-script', plugin_dir_url(REZFUSION_PLUGIN) . '/assets/js/property-card-flag.js');
        $attributes['promoCodePropertiesIds'] = $this->ItemRepository->getPromoCodePropertiesIds();
        $attributes['promoCodeFlagText'] = (!empty($promoCodeFlagText = get_option('rezfusion_hub_promo_code_flag_text'))) ? $promoCodeFlagText : 'Special!';
    }
}
