<?php

namespace Rezfusion;

/**
 * Singleton class holding all options names for component.
 */
class Options
{

    /**
     * @var
     */
    const PREFIX = "rezfusion_hub_";

    /**
     * @var
     */
    const FEATURED_PROPERTIES = "featured-properties";

    /**
     * @var
     */
    const FEATURED_PROPERTIES_USE_ICONS = "use_icons";

    /**
     * @var
     */
    const FEATURED_PROPERTIES_BEDS_LABEL = "beds_label";

    /**
     * @var
     */
    const FEATURED_PROPERTIES_BATHS_LABEL = "baths_label";

    /**
     * @var
     */
    const FEATURED_PROPERTIES_SLEEPS_LABEL = "sleeps_label";

    /**
     * @var
     */
    const FEATURED_PROPERTIES_PROPERTIES_IDS = "properties_ids";

    /**
     * @return string
     */
    public static function featuredPropertiesUseIcons()
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_USE_ICONS;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBedsLabel()
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_BEDS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBathsLabel()
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_BATHS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesSleepsLabel()
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_SLEEPS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesIds()
    {
        return static::PREFIX . static::FEATURED_PROPERTIES_BEDS_LABEL . static::FEATURED_PROPERTIES_PROPERTIES_IDS;
    }
}
