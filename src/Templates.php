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
    const FEATURED_PROPERTIES_CONFIGURATION_TEMPLATE = 'configuration-featured-properties.php';

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
    const REVIEWS_CONFIGURATION_PAGE = 'configuration-reviews.php';

    /**
     * @var string
     */
    const REVIEWS_LIST_PAGE = 'reviews-list.php';

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
    public static function reviewSubmitForm(): string
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
}