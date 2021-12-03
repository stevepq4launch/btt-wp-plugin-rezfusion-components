<?php

namespace Rezfusion;

class Assets
{
    /**
     * @var string
     */
    const REZFUSION_SCRIPT = 'rezfusion.js';

    /**
     * @var string
     */
    const REZFUSION_STYLE = 'rezfusion.css';

    /**
     * @var string
     */
    const REZFUSION_STARS_RATING_STYLE = 'rezfusion-stars-rating.css';

    /**
     * @var string
     */
    const REZFUSION_STARS_RATING_SCRIPT = 'rezfusion-stars-rating.js';

    /**
     * @var string
     */
    const REZFUSION_FIELDS_VALIDATION_STYLE = 'rezfusion-fields-validation.css';

    /**
     * @var string
     */
    const REZFUSION_FIELDS_VALIDATION_SCRIPT = 'rezfusion-fields-validation.js';

    /**
     * @var string
     */
    const REZFUSION_MODAL_STYLE = 'rezfusion-modal.css';

    /**
     * @var string
     */
    const REZFUSION_MODAL_SCRIPT = 'rezfusion-modal.js';

    /**
     * @var string
     */
    const REZFUSION_REVIEW_SUBMIT_FORM_SCRIPT = 'rezfusion-review-submit-form.js';

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_STYLE = 'featured-properties-configuration.css';

    /**
     * @var string
     */
    const FEATURED_PROPERTIES_CONFIGURATION_COMPONENT_HANDLER_SCRIPT = 'featured-properties-configuration-component-handler.js';

    /**
     * @var string
     */
    const PROPERTY_CARD_FLAG_STYLE = 'property-card-flag.css';

    /**
     * @var string
     */
    const PROPERTY_CARD_FLAG_SCRIPT = 'property-card-flag.js';

    /**
     * @var string
     */
    const QUICK_SEARCH_STYLE = 'vr-quick-search.css';

    /**
     * @var string
     */
    const REVIEWS_MODAL_HANDLER_SCRIPT = 'rezfusion-reviews-modal-handler.js';

    /**
     * @var string
     */
    const FAVORITES_STYLE = 'favorites.css';

    /**
     * @var string
     */
    const LOCAL_BUNDLE_SCRIPT = 'rezfusion-components/dist/main.js';

    /**
     * @return string
     */
    public static function rezfusionScript(): string
    {
        return static::REZFUSION_SCRIPT;
    }

    /**
     * @return string
     */
    public static function rezfusionStyle(): string
    {
        return static::REZFUSION_STYLE;
    }

    /**
     * @return string
     */
    public static function rezfusionStarsRatingStyle(): string
    {
        return static::REZFUSION_STARS_RATING_STYLE;
    }

    /**
     * @return string
     */
    public static function rezfusionStarsRatingScript(): string
    {
        return static::REZFUSION_STARS_RATING_SCRIPT;
    }

    /**
     * @return string
     */
    public static function rezfusionFieldsValidationStyle(): string
    {
        return static::REZFUSION_FIELDS_VALIDATION_STYLE;
    }

    /**
     * @return string
     */
    public static function rezfusionFieldsValidationScript(): string
    {
        return static::REZFUSION_FIELDS_VALIDATION_SCRIPT;
    }

    public static function rezfusionModalStyle(): string
    {
        return static::REZFUSION_MODAL_STYLE;
    }

    /**
     * @return string
     */
    public static function rezfusionModalScript(): string
    {
        return static::REZFUSION_MODAL_SCRIPT;
    }

    /**
     * @return string
     */
    public static function rezfusionReviewSubmitFormScript(): string
    {
        return static::REZFUSION_REVIEW_SUBMIT_FORM_SCRIPT;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesConfigurationComponentHandlerScript(): string
    {
        return static::FEATURED_PROPERTIES_CONFIGURATION_COMPONENT_HANDLER_SCRIPT;
    }

    /**
     * @return string
     */
    public static function featuredPropertiesStyle(): string
    {
        return static::FEATURED_PROPERTIES_STYLE;
    }

    /**
     * @return string
     */
    public static function quickSearchStyle(): string
    {
        return static::QUICK_SEARCH_STYLE;
    }

    /**
     * @return string
     */
    public static function propertyCardFlagStyle(): string
    {
        return static::PROPERTY_CARD_FLAG_STYLE;
    }

    /**
     * @return string
     */
    public static function propertyCardFlagScript(): string
    {
        return static::PROPERTY_CARD_FLAG_SCRIPT;
    }

    /**
     * @return string
     */
    public static function reviewsModalHandlerScript(): string
    {
        return static::REVIEWS_MODAL_HANDLER_SCRIPT;
    }

    /**
     * @return string
     */
    public static function favoritesStyle(): string
    {
        return static::FAVORITES_STYLE;
    }

    /**
     * @return string
     */
    public static function localBundleScript(): string
    {
        return static::LOCAL_BUNDLE_SCRIPT;
    }
}
