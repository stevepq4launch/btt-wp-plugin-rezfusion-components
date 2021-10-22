<?php

/**
 * @file Tests for Templates names.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Templates;

class TemplatesLiteralsTest extends BaseTestCase
{
    public function testFeaturedPropertiesTemplateIsValid()
    {
        $this->assertSame('vr-featured-properties.php', Templates::featuredPropertiesTemplate());
    }

    public function testFeaturedPropertiesConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-featured-properties.php', Templates::featuredPropertiesConfigurationTemplate());
    }

    public function testReviewsTemplateIsValid()
    {
        $this->assertSame('vr-reviews.php', Templates::reviewsTemplate());
    }

    public function testReviewSubmitFormTemplateIsValid()
    {
        $this->assertSame('vr-review-submit-form.php', Templates::reviewSubmitFormTemplate());
    }

    public function testReviewsConfigurationPageIsValid()
    {
        $this->assertSame('admin/configuration-reviews.php', Templates::reviewsConfigurationPage());
    }

    public function testReviewsListPageIsValid()
    {
        $this->assertSame('admin/reviews-list.php', Templates::reviewsListPage());
    }

    public function testModalOpenPartialIsValid()
    {
        $this->assertSame('partials/vr-modal-open.php', Templates::modalOpenPartial());
    }

    public function testModalClosePartialIsValid()
    {
        $this->assertSame('partials/vr-modal-close.php', Templates::modalClosePartial());
    }

    public function testPropertyDetailsParialIsValid()
    {
        $this->assertSame('partials/property-details.php', Templates::propertyDetailsParial());
    }

    public function testHubConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/hub-configuration.php', Templates::hubConfigurationTemplate());
    }

    public function testQuickSearchTemplateIsValid()
    {
        $this->assertSame('vr-quick-search.php', Templates::quickSearchTemplate());
    }

    public function testMapTemplateIsValid()
    {
        $this->assertSame('vr-url-map.php', Templates::mapTemplate());
    }

    public function testComponentTemplateIsValid()
    {
        $this->assertSame('vr-component.php', Templates::componentTemplate());
    }

    public function testDetailsPageTemplateIsValid()
    {
        $this->assertSame('vr-details-page.php', Templates::detailsPageTemplate());
    }

    public function testItemFlagTemplateIsValid()
    {
        $this->assertSame('vr-item-flag.php', Templates::itemFlagTemplate());
    }

    public function testItemPhotosTemplateIsValid()
    {
        $this->assertSame('vr-item-photos.php', Templates::itemPhotosTemplate());
    }

    public function testItemAvailPickerTemplateIsValid()
    {
        $this->assertSame('vr-item-avail-picker.php', Templates::itemAvailPickerTemplate());
    }

    public function testItemAvailCalendarTemplateIsValid()
    {
        $this->assertSame('vr-item-avail-calendar.php', Templates::itemAvailCalendarTemplate());
    }

    public function testItemPoliciesTemplateIsValid()
    {
        $this->assertSame('vr-item-policies.php', Templates::itemPoliciesTemplate());
    }

    public function testItemReviewsTemplateIsValid()
    {
        $this->assertSame('vr-item-reviews.php', Templates::itemReviewsTemplate());
    }

    public function testItemAmenitiesTemplateIsValid()
    {
        $this->assertSame('vr-item-amenities.php', Templates::itemAmenitiesTemplate());
    }

    public function testFavoriteToggleTemplateIsValid()
    {
        $this->assertSame('vr-favorite-toggle.php', Templates::favoriteToggleTemplate());
    }

    public function testFavoritesTemplateIsValid()
    {
        $this->assertSame('vr-favorites.php', Templates::favoritesTemplate());
    }

    public function testSearchTemplateIsValid()
    {
        $this->assertSame('vr-search.php', Templates::searchTemplate());
    }

    public function testUrgencyAlertTemplateIsValid()
    {
        $this->assertSame('vr-urgency-alert.php', Templates::urgencyAlertTemplate());
    }

    public function testPropertiesAdTemplateIsValid()
    {
        $this->assertSame('vr-properties-ad.php', Templates::propertiesAdTemplate());
    }

    public function testGeneralConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-general.php', Templates::generalConfigurationTemplate());
    }

    public function testPoliciesConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-policies.php', Templates::policiesConfigurationTemplate());
    }

    public function testAmenitiesConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-amenities.php', Templates::amenitiesConfigurationTemplate());
    }

    public function testFormsConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-forms.php', Templates::formsConfigurationTemplate());
    }

    public function testUrgencyAlertConfigurationTemplateIsValid()
    {
        $this->assertSame('admin/configuration-urgency-alert.php', Templates::urgencyAlertConfigurationTemplate());
    }

    public function testConfigurationPageTemplateIsValid()
    {
        $this->assertSame('admin/configuration.php', Templates::configurationPageTemplate());
    }

    public function testItemsConfigurationPageTemplateIsValid()
    {
        $this->assertSame('admin/lodging-item.php', Templates::itemsConfigurationPageTemplate());
    }

    public function testCategoriesConfigurationPageTemplateIsValid()
    {
        $this->assertSame('admin/category-info.php', Templates::categoriesConfigurationPageTemplate());
    }

    public function testCategoriesDisplayTemplateIsValid()
    {
        $this->assertSame('vr-categories-display.php', Templates::categoriesDisplayTemplate());
    }

    public function testSleepingArrangementsTemplateIsValid()
    {
        $this->assertSame('property-sleeping-arrangements.php', Templates::sleepingArrangementsTemplate());
    }

}
