<?php

namespace Rezfusion;

/**
 * Singleton class holding all options names for component.
 */
class Options
{

    /**
     * @var string
     */
    const PREFIX = "rezfusion_hub_";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES = "featured-properties";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_USE_ICONS = "use_icons";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_BEDS_LABEL = "beds_label";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_BATHS_LABEL = "baths_label";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_SLEEPS_LABEL = "sleeps_label";

    /**
     * @var string
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
     * @var string
     */
    const HUB_CHANNEL = 'channel';

    /**
     * @var string
     */
    const NEW_REVIEW_NOTIFICATION_RECIPIENTS = 'new_review_notification_recipients';

    /**
     * @var int
     */
    const MAX_REVIEW_RATING = 5;

    /**
     * @return string
     */
    public static function featuredPropertiesUseIcons(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_USE_ICONS;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBedsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_BEDS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBathsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_BATHS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesSleepsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . static::FEATURED_PROPERTIES_SLEEPS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesIds(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES_BEDS_LABEL . static::FEATURED_PROPERTIES_PROPERTIES_IDS;
    }

    /**
     * @return string
     */
    public static function hubChannel(): string
    {
        return static::PREFIX . 'channel';
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

    /**
     * @return string
     */
    public static function newReviewNotificationRecipients(): string
    {
        return static::PREFIX . static::NEW_REVIEW_NOTIFICATION_RECIPIENTS;
    }

    /**
     * @return $int
     */
    public static function maxReviewRating(): string
    {
        return static::MAX_REVIEW_RATING;
    }
}
