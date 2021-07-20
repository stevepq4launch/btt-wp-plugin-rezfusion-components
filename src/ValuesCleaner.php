<?php

namespace Rezfusion;

use Rezfusion\Helper\SlugifierInterface;

class ValuesCleaner
{

    /**
     * @var SlugifierInterface
     */
    protected $Slugifier;

    public function __construct(SlugifierInterface $Slugifier)
    {
        $this->Slugifier = $Slugifier;
    }

    /**
     * @param array $values
     * 
     * @return array
     */
    public function clean(array $values = [])
    {
        foreach (['rezfusion_hub_custom_listing_slug', 'rezfusion_hub_custom_promo_slug'] as $key) {
            if (array_key_exists($key, $values) && !empty($values[$key]))
                $values[$key] = $this->Slugifier->slugify($values[$key]);
        }
        return $values;
    }
}
