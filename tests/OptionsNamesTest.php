<?php

/**
 * @file Test if options methods returns appropriate names.
 */

namespace Rezfusion\Tests;

use Rezfusion\Options;

class OptionsNamesTest extends BaseTestCase
{
    public function testFeaturedPropertiesUseIcons()
    {
        $this->assertSame(Options::featuredPropertiesUseIcons(), 'rezfusion_hub_featured-properties_use_icons');
    }

    public function testFeaturedPropertiesBedsLabel()
    {
        $this->assertSame(Options::featuredPropertiesBedsLabel(), 'rezfusion_hub_featured-properties_beds_label');
    }

    public function testFeaturedPropertiesBathsLabel()
    {
        $this->assertSame(Options::featuredPropertiesBathsLabel(), 'rezfusion_hub_featured-properties_baths_label');
    }

    public function testFeaturedPropertiesSleepsLabel()
    {
        $this->assertSame(Options::featuredPropertiesSleepsLabel(), 'rezfusion_hub_featured-properties_sleeps_label');
    }

    public function testFeaturedPropertiesIds()
    {
        $this->assertSame(Options::featuredPropertiesIds(), 'rezfusion_hub_featured-properties_properties_ids');
    }

    public function testHubChannelURL()
    {
        $this->assertSame(Options::hubChannelURL(), 'rezfusion_hub_channel');
    }

    public function testComponentsURL()
    {
        $this->assertSame(Options::componentsURL(), 'rezfusion_hub_folder');
    }

    public function testSPS_Domain()
    {
        $this->assertSame(Options::SPS_Domain(), 'rezfusion_hub_sps_domain');
    }

    public function testBookingConfirmationURL()
    {
        $this->assertSame(Options::bookingConfirmationURL(), 'rezfusion_hub_conf_page');
    }

    public function testNewReviewNotificationRecipients()
    {
        $this->assertSame(Options::newReviewNotificationRecipients(), 'rezfusion_hub_new_review_notification_recipients');
    }

    public function testMaxReviewRating()
    {
        $this->assertSame(Options::maxReviewRating(), 'rezfusion_hub_max_review_rating');
    }

    public function testEnableFavorites()
    {
        $this->assertSame(Options::enableFavorites(), 'rezfusion_hub_enable_favorites');
    }

    public function testMapAPI_Key()
    {
        $this->assertSame(Options::mapAPI_Key(), 'rezfusion_hub_google_maps_api_key');
    }

    public function testCustomListingSlug()
    {
        $this->assertSame(Options::customListingSlug(), 'rezfusion_hub_custom_listing_slug');
    }

    public function testThemeURL()
    {
        $this->assertSame(Options::themeURL(), 'rezfusion_hub_theme');
    }

    public function testBlueprintURL()
    {
        $this->assertSame(Options::blueprintURL(), 'rezfusion_hub_blueprint_url');
    }

    public function testEnvironment()
    {
        $this->assertSame(Options::environment(), 'rezfusion_hub_env');
    }

    public function testFontsURL()
    {
        $this->assertSame(Options::fontsURL(), 'rezfusion_hub_fonts_url');
    }

    public function testConfiguration()
    {
        $this->assertSame(Options::configuration(), 'rezfusion_hub_configuration');
    }
}
