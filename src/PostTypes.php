<?php

namespace Rezfusion;

class PostTypes
{
    /**
     * The base `vr_listing` post type name.
     * @var string
     */
    const VR_LISTING_NAME = "vr_listing";

    /**
     * @var string
     */
    const VR_PROMO_NAME = "vr_promo";

    /**
     * @return string
     */
    public static function listing(): string
    {
        return static::VR_LISTING_NAME;
    }

    /**
     * @return string
     */
    public static function promo(): string
    {
        return static::VR_PROMO_NAME;
    }
}
