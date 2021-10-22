<?php

namespace Rezfusion\Helper;

use Rezfusion\Assets;
use Rezfusion\Options;
use Rezfusion\Repository\ItemRepository;

class PromoCodePropertiesHelper
{

    /**
     * @var AssetsRegistererInterface
     */
    protected $AssetsRegisterer;

    /**
     * @var ItemRepository
     */
    protected $ItemRepository;

    /**
     * @param AssetsRegistererInterface $AssetsRegisterer
     * @param ItemRepository $ItemRepository
     */
    public function __construct(AssetsRegistererInterface $AssetsRegisterer, ItemRepository $ItemRepository)
    {
        $this->AssetsRegisterer = $AssetsRegisterer;
        $this->ItemRepository = $ItemRepository;
    }

    /**
     * @param array $attributes
     */
    public function handle(&$attributes = [])
    {
        $this->AssetsRegisterer->handleStyle(Assets::propertyCardFlagStyle());
        $this->AssetsRegisterer->handleScript(Assets::propertyCardFlagScript());
        $attributes['promoCodePropertiesIds'] = $this->ItemRepository->getPromoCodePropertiesIds();
        $attributes['promoCodeFlagText'] = (!empty($promoCodeFlagText = get_rezfusion_option(Options::promoCodeFlagText()))) ? $promoCodeFlagText : 'Special!';
    }
}
