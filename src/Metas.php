<?php

namespace Rezfusion;

class Metas
{
    /**
     * @var string
     */
    const BEDS = 'rezfusion_hub_beds';

    /**
     * @var string
     */
    const BATHS = 'rezfusion_hub_baths';

    /**
     * @var string
     */
    const CATEGORY_ID = 'rezfusion_hub_category_id';

    /**
     * @var string
     */
    const CATEGORY_VALUE_ID = 'rezfusion_hub_category_value_id';

    /**
     * @var string
     */
    const ITEM_ID = 'rezfusion_hub_item_id';

    /**
     * @var string
     */
    const PROMO_LISTING_VALUE = 'rzf_promo_listing_value';

    /**
     * @var string
     */
    const PROMO_CODE_VALUE = 'rzf_promo_code_value';

    /**
     * @var string
     */
    const POST_FLOOR_PLAN_URL = 'rezfusion_floor_plan_url';

    /**
     * @return string
     */
    public static function beds(): string
    {
        return static::BEDS;
    }

    /**
     * @return string
     */
    public static function baths(): string
    {
        return static::BATHS;
    }

    /**
     * @return string
     */
    public static function categoryId(): string
    {
        return static::CATEGORY_ID;
    }

    /**
     * @return string
     */
    public static function categoryValueId(): string
    {
        return static::CATEGORY_VALUE_ID;
    }

    /**
     * @return string
     */
    public static function itemId(): string
    {
        return static::ITEM_ID;
    }

    /**
     * @return string
     */
    public static function promoListingValue(): string
    {
        return static::PROMO_LISTING_VALUE;
    }

    public static function promoCodeValue(): string
    {
        return static::PROMO_CODE_VALUE;
    }

    /**
     * @return string
     */
    public static function postFloorPlanURL(): string
    {
        return static::POST_FLOOR_PLAN_URL;
    }
}
