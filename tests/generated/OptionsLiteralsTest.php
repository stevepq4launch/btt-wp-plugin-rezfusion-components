<?php

/**
 * @file Tests for options names.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Options;

class OptionsLiteralsTest extends BaseTestCase
{
    public function testFeaturedPropertiesUseIcons()
    {
        $this->assertSame('rezfusion_hub_featured-properties_use_icons', Options::featuredPropertiesUseIcons());
    }

    public function testFeaturedPropertiesBedsLabel()
    {
        $this->assertSame('rezfusion_hub_featured-properties_beds_label', Options::featuredPropertiesBedsLabel());
    }

    public function testFeaturedPropertiesBathsLabel()
    {
        $this->assertSame('rezfusion_hub_featured-properties_baths_label', Options::featuredPropertiesBathsLabel());
    }

    public function testFeaturedPropertiesSleepsLabel()
    {
        $this->assertSame('rezfusion_hub_featured-properties_sleeps_label', Options::featuredPropertiesSleepsLabel());
    }

    public function testFeaturedPropertiesIds()
    {
        $this->assertSame('rezfusion_hub_featured-properties_properties_ids', Options::featuredPropertiesIds());
    }

    public function testHubChannelURL()
    {
        $this->assertSame('rezfusion_hub_channel', Options::hubChannelURL());
    }

    public function testComponentsURL()
    {
        $this->assertSame('rezfusion_hub_folder', Options::componentsURL());
    }

    public function testSPS_Domain()
    {
        $this->assertSame('rezfusion_hub_sps_domain', Options::SPS_Domain());
    }

    public function testBookingConfirmationURL()
    {
        $this->assertSame('rezfusion_hub_conf_page', Options::bookingConfirmationURL());
    }

    public function testNewReviewNotificationRecipients()
    {
        $this->assertSame('rezfusion_hub_new_review_notification_recipients', Options::newReviewNotificationRecipients());
    }

    public function testMaxReviewRating()
    {
        $this->assertSame('rezfusion_hub_max_review_rating', Options::maxReviewRating());
    }

    public function testRepositoryURL()
    {
        $this->assertSame('rezfusion_hub_repository_url', Options::repositoryURL());
    }

    public function testRepositoryToken()
    {
        $this->assertSame('rezfusion_hub_repository_token', Options::repositoryToken());
    }

    public function testEnableFavorites()
    {
        $this->assertSame('rezfusion_hub_enable_favorites', Options::enableFavorites());
    }

    public function testMapAPI_Key()
    {
        $this->assertSame('rezfusion_hub_google_maps_api_key', Options::mapAPI_Key());
    }

    public function testCustomListingSlug()
    {
        $this->assertSame('rezfusion_hub_custom_listing_slug', Options::customListingSlug());
    }

    public function testCustomPromoSlug()
    {
        $this->assertSame('rezfusion_hub_custom_promo_slug', Options::customPromoSlug());
    }

    public function testPromoCodeFlagText()
    {
        $this->assertSame('rezfusion_hub_promo_code_flag_text', Options::promoCodeFlagText());
    }

    public function testThemeURL()
    {
        $this->assertSame('rezfusion_hub_theme', Options::themeURL());
    }

    public function testBlueprintURL()
    {
        $this->assertSame('rezfusion_hub_blueprint_url', Options::blueprintURL());
    }

    public function testEnvironment()
    {
        $this->assertSame('rezfusion_hub_env', Options::environment());
    }

    public function testFontsURL()
    {
        $this->assertSame('rezfusion_hub_fonts_url', Options::fontsURL());
    }

    public function testConfiguration()
    {
        $this->assertSame('rezfusion_hub_configuration', Options::configuration());
    }

    public function testRedirectUrls()
    {
        $this->assertSame('rezfusion_hub_redirect_urls', Options::redirectUrls());
    }

    public function testTriggerRewriteFlush()
    {
        $this->assertSame('rezfusion_trigger_rewrite_flush', Options::triggerRewriteFlush());
    }

    public function testSyncItems()
    {
        $this->assertSame('rezfusion_hub_sync_items', Options::syncItems());
    }

    public function testSyncItemsPostType()
    {
        $this->assertSame('rezfusion_hub_sync_items_post_type', Options::syncItemsPostType());
    }

    public function testPoliciesGeneral()
    {
        $this->assertSame('rezfusion_hub_policies_general', Options::policiesGeneral());
    }

    public function testPoliciesPets()
    {
        $this->assertSame('rezfusion_hub_policies_pets', Options::policiesPets());
    }

    public function testPoliciesPayment()
    {
        $this->assertSame('rezfusion_hub_policies_payment', Options::policiesPayment());
    }

    public function testPoliciesCancellation()
    {
        $this->assertSame('rezfusion_hub_policies_cancellation', Options::policiesCancellation());
    }

    public function testPoliciesChanging()
    {
        $this->assertSame('rezfusion_hub_policies_changing', Options::policiesChanging());
    }

    public function testPoliciesInsurance()
    {
        $this->assertSame('rezfusion_hub_policies_insurance', Options::policiesInsurance());
    }

    public function testPoliciesCleaning()
    {
        $this->assertSame('rezfusion_hub_policies_cleaning', Options::policiesCleaning());
    }

    public function testAmenitiesFeatured()
    {
        $this->assertSame('rezfusion_hub_amenities_featured', Options::amenitiesFeatured());
    }

    public function testAmenitiesGeneral()
    {
        $this->assertSame('rezfusion_hub_amenities_general', Options::amenitiesGeneral());
    }

    public function testReviewButtonText()
    {
        $this->assertSame('rezfusion_hub_review_btn_text', Options::reviewButtonText());
    }

    public function testReviewForm()
    {
        $this->assertSame('rezfusion_hub_review_form', Options::reviewForm());
    }

    public function testInquiryButtonText()
    {
        $this->assertSame('rezfusion_hub_inquiry_btn_text', Options::inquiryButtonText());
    }

    public function testInquiryForm()
    {
        $this->assertSame('rezfusion_hub_inquiry_form', Options::inquiryForm());
    }

    public function testUrgencyAlertEnabled()
    {
        $this->assertSame('rezfusion_hub_urgency_alert_enabled', Options::urgencyAlertEnabled());
    }

    public function testUrgencyAlertDaysThreshold()
    {
        $this->assertSame('rezfusion_hub_urgency_alert_days_threshold', Options::urgencyAlertDaysThreshold());
    }

    public function testUrgencyAlertMinimumVisitors()
    {
        $this->assertSame('rezfusion_hub_urgency_alert_minimum_visitors', Options::urgencyAlertMinimumVisitors());
    }

    public function testUrgencyAlertHighlightedText()
    {
        $this->assertSame('rezfusion_hub_urgency_alert_highlighted_text', Options::urgencyAlertHighlightedText());
    }

    public function testUrgencyAlertText()
    {
        $this->assertSame('rezfusion_hub_urgency_alert_text', Options::urgencyAlertText());
    }

    public function testDateFormat()
    {
        $this->assertSame('date_format', Options::dateFormat());
    }

    public function testFavoritesNamespace()
    {
        $this->assertSame('rezfusion_hub_favorites_namespace', Options::favoritesNamespace());
    }

    public function testOptionGroup()
    {
        $this->assertSame('rezfusion-components', Options::optionGroup());
    }

    public function testURL_Map()
    {
        $this->assertSame('rezfusion_hub_url_map', Options::URL_Map());
    }

    public function testComponentsBundleURL()
    {
        $this->assertSame('components_bundle_url', Options::componentsBundleURL());
    }

    public function testComponentsCSS_URL()
    {
        $this->assertSame('components_css_url', Options::componentsCSS_URL());
    }

}
