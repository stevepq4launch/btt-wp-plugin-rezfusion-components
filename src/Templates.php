<?php

namespace Rezfusion;

/**
 * Templates (and partials) file names are kept here.
 */
class Templates
{

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_TEMPLATE = "vr-featured-properties.php";

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_CONFIGURATION_TEMPLATE = 'admin/configuration-featured-properties.php';

    /**
     * @var string
     */
    const REVIEWS_TEMPLATE = "vr-reviews.php";

    /**
     * @var string
     */
    const REVIEW_PLUGIN_FORM = 'vr-review-submit-form.php';

    /**
     * @var string
     */
    const REVIEWS_CONFIGURATION_PAGE = 'admin/configuration-reviews.php';

    /**
     * @var string
     */
    const REVIEWS_LIST_PAGE = 'admin/reviews-list.php';

    /**
     * @var string
     */
    const MODAL_OPEN_PARTIAL = 'partials/vr-modal-open.php';

    /**
     * @var string
     */
    const MODAL_CLOSE_PARTIAL = 'partials/vr-modal-close.php';

    /**
     * @var string
     */
    const PROPERTY_DETAILS_PARTIAL = 'partials/property-details.php';

    /**
     * @var string
     */
    const HUB_CONFIGURATION_TEMPLATE = 'admin/hub-configuration.php';

    /**
     * @var string
     */
    const QUICK_SEARCH_TEMPLATE = 'vr-quick-search.php';

    /**
     * @var string
     */
    const MAP_TEMPLATE = 'vr-url-map.php';

    /**
     * @var string
     */
    const COMPONENT_TEMPLATE = 'vr-component.php';

    /**
     * @var string 
     */
    const DETAILS_PAGE_TEMPLATE = 'vr-details-page.php';

    /**
     * @var string
     */
    const ITEM_FLAG_TEMPLATE = 'vr-item-flag.php';

    /**
     * @var string
     */
    const ITEM_PHOTOS_TEMPLATE = 'vr-item-photos.php';

    /**
     * @var string
     */
    const ITEM_AVAIL_PICKER_TEMPLATE = 'vr-item-avail-picker.php';

    /**
     * @var string
     */
    const ITEM_AVAIL_CALENDAR_TEMPLATE = 'vr-item-avail-calendar.php';

    /**
     * @var string
     */
    const ITEM_POLICIES_TEMPLATE = 'vr-item-policies.php';

    /**
     * @var string
     */
    const ITEM_REVIEWS_TEMPLATE = 'vr-item-reviews.php';

    /**
     * @var string
     */
    const ITEM_AMENITIES_TEMPLATE = 'vr-item-amenities.php';

    /**
     * @var string
     */
    const FAVORITE_TOGGLE_TEMPLATE = 'vr-favorite-toggle.php';

    /**
     * @var string
     */
    const FAVORITES_TEMPLATE = 'vr-favorites.php';

    /**
     * @var string
     */
    const SEARCH_TEMPLATE = 'vr-search.php';

    /**
     * @var string
     */
    const URGENCY_ALERT_TEMPLATE = 'vr-urgency-alert.php';

    /**
     * @var string
     */
    const PROPERTIES_AD_TEMPLATE = 'vr-properties-ad.php';

    /**
     * @var string
     */
    const GENERAL_CONFIGURATION_TEMPLATE = 'admin/configuration-general.php';

    /**
     * @var string
     */
    const POLICIES_CONFIGURATION_TEMPLATE = 'admin/configuration-policies.php';

    /**
     * @var string
     */
    const AMENITIES_CONFIGURATION_TEMPLATE = 'admin/configuration-amenities.php';

    /**
     * @var string
     */
    const FORMS_CONFIGURATION_TEMPLATE = 'admin/configuration-forms.php';

    /**
     * @var string
     */
    const URGENCY_ALERT_CONFIGURATION_TEMPLATE = 'admin/configuration-urgency-alert.php';

    /**
     * @var string
     */
    const CONFIGURATION_PAGE_TEMPLATE = 'admin/configuration.php';

    /**
     * @var string
     */
    const ITEMS_CONFIGURATION_PAGE_TEMPLATE = 'admin/lodging-item.php';

    /**
     * @var string
     */
    const CATEGORIES_CONFIGURATION_PAGE_TEMPLATE = 'admin/category-info.php';

    /**
     * Default Category Display partial.
     * @var string
     */
    const CATEGORIES_DISPLAY_TEMPLATE = 'vr-categories-display.php';
    
    /**
     * Default template name of Sleeping Arrangements partial.
     * @var string
     */
    const SLEEPING_ARRANGEMENTS_TEMPLATE = 'property-sleeping-arrangements.php';

    /**
     * @return string
     */
    public static function featuredPropertiesTemplate(): string
    {
        return static::FEATURED_PROPERTIES_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesConfigurationTemplate(): string
    {
        return static::FEATURED_PROPERTIES_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function reviewsTemplate(): string
    {
        return static::REVIEWS_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function reviewSubmitFormTemplate(): string
    {
        return static::REVIEW_PLUGIN_FORM;
    }

    /**
     * @return string
     */
    public static function reviewsConfigurationPage(): string
    {
        return static::REVIEWS_CONFIGURATION_PAGE;
    }

    /**
     * @return string
     */
    public static function reviewsListPage(): string
    {
        return static::REVIEWS_LIST_PAGE;
    }

    /**
     * @return string
     */
    public static function modalOpenPartial(): string
    {
        return static::MODAL_OPEN_PARTIAL;
    }

    /**
     * @return string
     */
    public static function modalClosePartial(): string
    {
        return static::MODAL_CLOSE_PARTIAL;
    }

    /**
     * @return string
     */
    public static function propertyDetailsParial(): string
    {
        return static::PROPERTY_DETAILS_PARTIAL;
    }

    /**
     * @return string
     */
    public static function hubConfigurationTemplate(): string
    {
        return static::HUB_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function quickSearchTemplate(): string
    {
        return static::QUICK_SEARCH_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function mapTemplate(): string
    {
        return static::MAP_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function componentTemplate(): string
    {
        return static::COMPONENT_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function detailsPageTemplate(): string
    {
        return static::DETAILS_PAGE_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemFlagTemplate(): string
    {
        return static::ITEM_FLAG_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemPhotosTemplate(): string
    {
        return static::ITEM_PHOTOS_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemAvailPickerTemplate(): string
    {
        return static::ITEM_AVAIL_PICKER_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemAvailCalendarTemplate(): string
    {
        return static::ITEM_AVAIL_CALENDAR_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemPoliciesTemplate(): string
    {
        return static::ITEM_POLICIES_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemReviewsTemplate(): string
    {
        return static::ITEM_REVIEWS_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemAmenitiesTemplate(): string
    {
        return static::ITEM_AMENITIES_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function favoriteToggleTemplate(): string
    {
        return static::FAVORITE_TOGGLE_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function favoritesTemplate(): string
    {
        return static::FAVORITES_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function searchTemplate(): string
    {
        return static::SEARCH_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function urgencyAlertTemplate(): string
    {
        return static::URGENCY_ALERT_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function propertiesAdTemplate(): string
    {
        return static::PROPERTIES_AD_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function generalConfigurationTemplate(): string
    {
        return static::GENERAL_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function policiesConfigurationTemplate(): string
    {
        return static::POLICIES_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function amenitiesConfigurationTemplate(): string
    {
        return static::AMENITIES_CONFIGURATION_TEMPLATE;
    }

    /**
     * @var string
     */
    public static function formsConfigurationTemplate(): string
    {
        return static::FORMS_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function urgencyAlertConfigurationTemplate(): string
    {
        return static::URGENCY_ALERT_CONFIGURATION_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function configurationPageTemplate(): string
    {
        return static::CONFIGURATION_PAGE_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function itemsConfigurationPageTemplate(): string
    {
        return static::ITEMS_CONFIGURATION_PAGE_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function categoriesConfigurationPageTemplate(): string
    {
        return static::CATEGORIES_CONFIGURATION_PAGE_TEMPLATE;
    }

    /**
     * @return string
     */
    public static function categoriesDisplayTemplate(): string
    {
      return static::CATEGORIES_DISPLAY_TEMPLATE;
    }

    /**
     * Returns sleeping arrangements template name.
     * @return string
     */
    public static function sleepingArrangementsTemplate(): string
    {
      return static::SLEEPING_ARRANGEMENTS_TEMPLATE;
    }
}
