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
     * @var
     */
    const HUB_CHANNEL_URL = 'hub_channel';

    /**
     * @var
     */
    const COMPONENTS_URL = 'hub_folder';

    /**
     * @var
     */
    const SPS_DOMAIN = 'hub_sps_domain';

    /**
     * @var
     */
    const BOOKING_CONFIRMATION_URL = 'hub_conf_page';

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

    /**
     * @return string
     */
    public static function hubChannel(): string
    {
        return static::PREFIX . static::HUB_CHANNEL_URL;
    }

    /**
     * @return string
     */
    public static function componentsURL(): string
    {
        return static::PREFIX . static::COMPONENTS_URL;
    }

    /**
     * @return string
     */
    public static function SPS_Domain(): string
    {
        return static::PREFIX . static::SPS_DOMAIN;
    }

    /**
     * @return string
     */
    public static function bookingConfirmationURL(): string
    {
        return static::PREFIX . static::BOOKING_CONFIRMATION_URL;
    }
}
