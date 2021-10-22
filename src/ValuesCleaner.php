<?php

namespace Rezfusion;

use Rezfusion\Helper\SlugifierInterface;

class ValuesCleaner
{

    /**
     * @var SlugifierInterface
     */
    protected $Slugifier;

    /**
     * @param SlugifierInterface $Slugifier
     */
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
    public function clean(array $values = []): array
    {
        foreach ([Options::customListingSlug(), Options::customPromoSlug()] as $key) {
            if (array_key_exists($key, $values) && !empty($values[$key]))
                $values[$key] = $this->Slugifier->slugify($values[$key]);
        }

        foreach ([Options::componentsURL()] as $key) {
            if (array_key_exists($key, $values) && !empty($values[$key]))
                $values[$key] = $this->trimSlashes($values[$key]);
        }

        return $values;
    }
}
