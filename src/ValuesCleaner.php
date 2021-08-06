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
     * @param string $value
     * 
     * @return string
     */
    protected function trimSlashes($value): string
    {
        return trim($value, '/\\');
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

        foreach ([
            'rezfusion_hub_channel',
            'rezfusion_hub_folder',
            'rezfusion_hub_sps_domain',
            'rezfusion_hub_conf_page'
        ] as $key) {
            if (array_key_exists($key, $values) && !empty($values[$key]))
                $values[$key] = $this->trimSlashes($values[$key]);
        }

        return $values;
    }
}
