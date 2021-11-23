<?php

namespace Rezfusion;

class Taxonomies
{
    /**
     * @var string
     */
    const AMENITIES = 'rzf_amenities';

    /**
     * @var string
     */
    const LOCATION = 'rzf_location';

    /**
     * @return string
     */
    public static function amenities(): string
    {
        return static::AMENITIES;
    }

    /**
     * @return string
     */
    public static function location(): string
    {
        return static::LOCATION;
    }
}
