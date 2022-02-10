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
    const OPTION_GROUP = 'rezfusion-components';

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
    const REPOSITORY_URL = 'repository_url';

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
    const CUSTOM_PROMO_SLUG = 'rezfusion_hub_custom_promo_slug';

    /**
     * @var string
     */
    const PROMO_CODE_FLAG_TEXT = 'rezfusion_hub_promo_code_flag_text';

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
     * @var string
     */
    const REDIRECT_URLS = 'rezfusion_hub_redirect_urls';

    /**
     * @var string
     */
    const TRIGGER_REWRITE_FLUSH = 'rezfusion_trigger_rewrite_flush';

    /**
     * @var string
     */
    const SYNC_ITEMS = 'rezfusion_hub_sync_items';

    /**
     * @var string
     */
    const SYNC_ITEMS_POST_TYPE = 'rezfusion_hub_sync_items_post_type';

    /**
     * @var string
     */
    const POLICIES_GENERAL = 'rezfusion_hub_policies_general';

    /**
     * @var string
     */
    const POLICIES_PETS = 'rezfusion_hub_policies_pets';

    /**
     * @var string
     */
    const POLICIES_PAYMENT = 'rezfusion_hub_policies_payment';

    /**
     * @var string
     */
    const POLICIES_CANCELLATION = 'rezfusion_hub_policies_cancellation';

    /**
     * @var string
     */
    const POLICIES_CHANGING = 'rezfusion_hub_policies_changing';

    /**
     * @var string
     */
    const POLICIES_INSURANCE = 'rezfusion_hub_policies_insurance';

    /**
     * @var string
     */
    const POLICIES_CLEANING = 'rezfusion_hub_policies_cleaning';

    /**
     * @var string
     */
    const AMENITIES_FEATURED = 'rezfusion_hub_amenities_featured';

    /**
     * @var string
     */
    const AMENITIES_GENERAL = 'rezfusion_hub_amenities_general';

    /**
     * @var string
     */
    const REVIEW_BUTTON_TEXT = 'rezfusion_hub_review_btn_text';

    /**
     * @var string
     */
    const REVIEW_FORM = 'rezfusion_hub_review_form';

    /**
     * @var string
     */
    const INQUIRY_BUTTON_TEXT = 'rezfusion_hub_inquiry_btn_text';

    /**
     * @var string
     */
    const INQUIRY_FORM = 'rezfusion_hub_inquiry_form';

    /**
     * @var string
     */
    const URGENCY_ALERT_ENABLED = 'rezfusion_hub_urgency_alert_enabled';

    /**
     * @var string
     */
    const URGENCY_ALERT_DAYS_THRESHOLD = 'rezfusion_hub_urgency_alert_days_threshold';

    /**
     * @var string
     */
    const URGENCY_ALERT_MINIMUM_VISITORS = 'rezfusion_hub_urgency_alert_minimum_visitors';

    /**
     * @var string
     */
    const URGENCY_ALERT_HIGHLIGHTED_TEXT = 'rezfusion_hub_urgency_alert_highlighted_text';

    /**
     * @var string
     */
    const URGENCY_ALERT_TEXT = 'rezfusion_hub_urgency_alert_text';

    /**
     * @var string
     */
    const DATE_FORMAT = 'date_format';

    /**
     * @var string
     */
    const FAVORITES_NAMESPACE = 'rezfusion_hub_favorites_namespace';

    /**
     * @var string
     */
    const URL_MAP = 'rezfusion_hub_url_map';

    /**
     * @var string
     */
    const COMPONENTS_BUNDLE_URL = 'components_bundle_url';

    /**
     * @var string
     */
    const COMPONENTS_CSS_URL = 'components_css_url';

    /**
     * @var string
     */
    const HUB_DATA_SYNCHRONIZATION_LOG = 'hub_data_synchronization_log';

    /**
     * @return string
     */
    public static function prefix(): string
    {
        return static::PREFIX;
    }

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
    public static function repositoryURL(): string
    {
        return static::PREFIX . static::REPOSITORY_URL;
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
    public static function customPromoSlug(): string
    {
        return static::CUSTOM_PROMO_SLUG;
    }

    /**
     * @return string
     */
    public static function promoCodeFlagText(): string
    {
        return static::PROMO_CODE_FLAG_TEXT;
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

    /**
     * @return [type]
     */
    public static function redirectUrls(): string
    {
        return static::REDIRECT_URLS;
    }

    /**
     * @return string
     */
    public static function triggerRewriteFlush(): string
    {
        return static::TRIGGER_REWRITE_FLUSH;
    }

    /**
     * @return string
     */
    public static function syncItems(): string
    {
        return static::SYNC_ITEMS;
    }

    /**
     * @return string
     */
    public static function syncItemsPostType(): string
    {
        return static::SYNC_ITEMS_POST_TYPE;
    }

    /**
     * @return string
     */
    public static function policiesGeneral(): string
    {
        return static::POLICIES_GENERAL;
    }

    /**
     * @return string
     */
    public static function policiesPets(): string
    {
        return static::POLICIES_PETS;
    }

    /**
     * @return string
     */
    public static function policiesPayment(): string
    {
        return static::POLICIES_PAYMENT;
    }

    /**
     * @return string
     */
    public static function policiesCancellation(): string
    {
        return static::POLICIES_CANCELLATION;
    }

    /**
     * @return string
     */
    public static function policiesChanging(): string
    {
        return static::POLICIES_CHANGING;
    }

    /**
     * @return string
     */
    public static function policiesInsurance(): string
    {
        return static::POLICIES_INSURANCE;
    }

    /**
     * @return string
     */
    public static function policiesCleaning(): string
    {
        return static::POLICIES_CLEANING;
    }

    /**
     * @return string
     */
    public static function amenitiesFeatured(): string
    {
        return static::AMENITIES_FEATURED;
    }

    /**
     * @return string
     */
    public static function amenitiesGeneral(): string
    {
        return static::AMENITIES_GENERAL;
    }

    /**
     * @return string
     */
    public static function reviewButtonText(): string
    {
        return static::REVIEW_BUTTON_TEXT;
    }

    /**
     * @return string
     */
    public static function reviewForm(): string
    {
        return static::REVIEW_FORM;
    }

    /**
     * @return string
     */
    public static function inquiryButtonText(): string
    {
        return static::INQUIRY_BUTTON_TEXT;
    }

    /**
     * @return string
     */
    public static function inquiryForm(): string
    {
        return static::INQUIRY_FORM;
    }

    /**
     * @return string
     */
    public static function urgencyAlertEnabled(): string
    {
        return static::URGENCY_ALERT_ENABLED;
    }

    /**
     * @return string
     */
    public static function urgencyAlertDaysThreshold(): string
    {
        return static::URGENCY_ALERT_DAYS_THRESHOLD;
    }

    /**
     * @return string
     */
    public static function urgencyAlertMinimumVisitors(): string
    {
        return static::URGENCY_ALERT_MINIMUM_VISITORS;
    }

    /**
     * @return string
     */
    public static function urgencyAlertHighlightedText(): string
    {
        return static::URGENCY_ALERT_HIGHLIGHTED_TEXT;
    }

    /**
     * @return string
     */
    public static function urgencyAlertText(): string
    {
        return static::URGENCY_ALERT_TEXT;
    }

    /**
     * @return string
     */
    public static function dateFormat(): string
    {
        return static::DATE_FORMAT;
    }

    /**
     * @return string
     */
    public static function favoritesNamespace(): string
    {
        return static::FAVORITES_NAMESPACE;
    }

    /**
     * @return string
     */
    public static function optionGroup(): string
    {
        return static::OPTION_GROUP;
    }

    /**
     * @return string
     */
    public static function URL_Map(): string
    {
        return static::URL_MAP;
    }

    /**
     * @return string
     */
    public static function componentsBundleURL(): string
    {
        return static::COMPONENTS_BUNDLE_URL;
    }

    /**
     * @return string
     */
    public static function componentsCSS_URL(): string
    {
        return static::COMPONENTS_CSS_URL;
    }

    /**
     * @return string
     */
    public static function hubDataSynchronizationLog(): string
    {
        return static::prefix() . static::HUB_DATA_SYNCHRONIZATION_LOG;
    }

    /**
     * Array of options names retrieved from hub configuration.
     * @return array
     */
    public static function hubConfigurationOptions(): array
    {
        return [
            Options::componentsURL(),
            Options::hubChannelURL(),
            Options::bookingConfirmationURL(),
            Options::SPS_Domain(),
            Options::enableFavorites(),
            Options::mapAPI_Key(),
            Options::themeURL(),
            Options::blueprintURL(),
            Options::fontsURL(),
            Options::maxReviewRating(),
            Options::configuration(),
            Options::componentsBundleURL(),
            Options::componentsCSS_URL()
        ];
    }

    /**
     * @return string
     */
    public static function cron(): string
    {
        return 'cron';
    }
}
