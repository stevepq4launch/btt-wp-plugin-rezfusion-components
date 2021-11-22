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
     * @var string
     */
    const TYPE = 'rzf_type';

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

    /**
     * @return string
     */
    public static function type(): string
    {
        return static::TYPE;
    }
}
