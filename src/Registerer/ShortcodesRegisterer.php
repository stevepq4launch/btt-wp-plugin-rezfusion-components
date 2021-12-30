<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Shortcodes\CategoriesDisplay;
use Rezfusion\Shortcodes\Component;
use Rezfusion\Shortcodes\Favorites;
use Rezfusion\Shortcodes\FeaturedProperties;
use Rezfusion\Shortcodes\FloorPlan;
use Rezfusion\Shortcodes\ItemFlag;
use Rezfusion\Shortcodes\LodgingGlobalPolicies;
use Rezfusion\Shortcodes\LodgingItemAmenities;
use Rezfusion\Shortcodes\LodgingItemAvailCalendar;
use Rezfusion\Shortcodes\LodgingItemAvailPicker;
use Rezfusion\Shortcodes\LodgingItemDetails;
use Rezfusion\Shortcodes\LodgingItemFavoriteToggle;
use Rezfusion\Shortcodes\LodgingItemPhotos;
use Rezfusion\Shortcodes\LodgingItemReviews;
use Rezfusion\Shortcodes\PropertiesAd;
use Rezfusion\Shortcodes\QuickSearch;
use Rezfusion\Shortcodes\Reviews;
use Rezfusion\Shortcodes\ReviewSubmitForm;
use Rezfusion\Shortcodes\Search;
use Rezfusion\Shortcodes\SleepingArrangements;
use Rezfusion\Shortcodes\UrgencyAlert;
use Rezfusion\Template;
use Rezfusion\Templates;

class ShortcodesRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::init(), function () {
            new Component(new Template(Templates::componentTemplate()));
            new LodgingItemDetails(new Template(Templates::detailsPageTemplate()));
            new ItemFlag(new Template(Templates::itemFlagTemplate()));
            new LodgingItemPhotos(new Template(Templates::itemPhotosTemplate()));
            new LodgingItemAvailPicker(new Template(Templates::itemAvailPickerTemplate()));
            new LodgingItemAvailCalendar(new Template(Templates::itemAvailCalendarTemplate()));
            new LodgingGlobalPolicies(new Template(Templates::itemPoliciesTemplate()));
            new LodgingItemReviews(new Template(Templates::itemReviewsTemplate()));
            new LodgingItemAmenities(new Template(Templates::itemAmenitiesTemplate()));
            new LodgingItemFavoriteToggle(new Template(Templates::favoriteToggleTemplate()));
            new Favorites(new Template(Templates::favoritesTemplate()));
            new Search(new Template(Templates::searchTemplate()));
            new UrgencyAlert(new Template(Templates::urgencyAlertTemplate()));
            new PropertiesAd(new Template(Templates::propertiesAdTemplate()));
            new FeaturedProperties(new Template(Templates::featuredPropertiesTemplate()));
            new Reviews(new Template(Templates::reviewsTemplate()));
            new ReviewSubmitForm(new Template(Templates::reviewSubmitFormTemplate()));
            new QuickSearch(new Template(Templates::quickSearchTemplate()));
            new SleepingArrangements(new Template(Templates::sleepingArrangementsTemplate()));
            new CategoriesDisplay(new Template(Templates::categoriesDisplayTemplate()));
            new FloorPlan(new Template(Templates::floorPlanTemplate()));
        });
    }
}
