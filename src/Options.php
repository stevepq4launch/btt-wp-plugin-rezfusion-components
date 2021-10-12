<?php

namespace Rezfusion;

/**
 * @file Singleton class holding all options names for component.
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
     * @var string
     */
    const HUB_CHANNEL_URL = 'channel';

    /**
     * @var string
     */
    const COMPONENTS_URL = 'folder';

    /**
     * @var string
     */
    const SPS_DOMAIN = 'sps_domain';

    /**
     * @var string
     */
    const BOOKING_CONFIRMATION_URL = 'conf_page';

    /**
     * @var string
     */
    const NEW_REVIEW_NOTIFICATION_RECIPIENTS = 'new_review_notification_recipients';

    /**
     * @var string
     */
    const MAX_REVIEW_RATING = 'rezfusion_hub_max_review_rating';

    /**
     * @var string
     */
    const ENABLE_FAVORITES = 'rezfusion_hub_enable_favorites';

    /**
     * @var string
     */
    const REPOSITORY_TOKEN = "repository_token";

    /**
     * @var string
     */
    const MAP_API_KEY = 'rezfusion_hub_google_maps_api_key';

    /**
     * @var string
     */
    const CUSTOM_LISTING_SLUG = 'rezfusion_hub_custom_listing_slug';

    /**
     * @var string
     */
    const THEME_URL = 'rezfusion_hub_theme';

    /**
     * @var string
     */
    const BLUEPRINT_URL = 'rezfusion_hub_blueprint_url';

    /**
     * @var string
     */
    const ENVIRONMENT = 'rezfusion_hub_env';

    /**
     * @var string
     */
    const FONTS_URL = 'rezfusion_hub_fonts_url';

    /**
     * @var string
     */
    const CONFIGURATION = 'rezfusion_hub_configuration';

    /**
     * @return string
     */
    public static function featuredPropertiesUseIcons(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . '_' . static::FEATURED_PROPERTIES_USE_ICONS;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBedsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . '_' . static::FEATURED_PROPERTIES_BEDS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesBathsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . '_' . static::FEATURED_PROPERTIES_BATHS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesSleepsLabel(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . '_' . static::FEATURED_PROPERTIES_SLEEPS_LABEL;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesIds(): string
    {
        return static::PREFIX . static::FEATURED_PROPERTIES . '_' . static::FEATURED_PROPERTIES_PROPERTIES_IDS;
    }

    /**
     * @return string
     */
    public static function hubChannelURL(): string
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

    /**
     * @return string
     */
    public static function newReviewNotificationRecipients(): string
    {
        return static::PREFIX . static::NEW_REVIEW_NOTIFICATION_RECIPIENTS;
    }

    /**
     * @return string
     */
    public static function maxReviewRating(): string
    {
        return static::MAX_REVIEW_RATING;
    }

    /**
     * @return string
     */
    public static function repositoryToken(): string
    {
        return static::PREFIX . static::REPOSITORY_TOKEN;
    }

    /**
     * @return string
     */
    public static function enableFavorites(): string
    {
        return static::ENABLE_FAVORITES;
    }

    /**
     * @return string
     */
    public static function mapAPI_Key(): string
    {
        return static::MAP_API_KEY;
    }

    /**
     * @return string
     */
    public static function customListingSlug(): string
    {
        return static::CUSTOM_LISTING_SLUG;
    }

    /**
     * @return string
     */
    public static function themeURL(): string
    {
        return static::THEME_URL;
    }

    /**
     * @return string
     */
    public static function blueprintURL(): string
    {
        return static::BLUEPRINT_URL;
    }

    /**
     * @return string
     */
    public static function environment(): string
    {
        return static::ENVIRONMENT;
    }

    /**
     * @return string
     */
    public static function fontsURL(): string
    {
        return static::FONTS_URL;
    }

    /**
     * @return string
     */
    public static function configuration(): string
    {
        return static::CONFIGURATION;
    }
}
