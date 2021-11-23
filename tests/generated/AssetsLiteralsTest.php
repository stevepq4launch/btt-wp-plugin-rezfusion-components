<?php

/**
 * @file Tests for Assets literals.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Assets;

class AssetsLiteralsTest extends BaseTestCase
{
    public function testRezfusionScript()
    {
        $this->assertSame('rezfusion.js', Assets::rezfusionScript());
    }

    public function testRezfusionStarsRatingStyle()
    {
        $this->assertSame('rezfusion-stars-rating.css', Assets::rezfusionStarsRatingStyle());
    }

    public function testRezfusionStarsRatingScript()
    {
        $this->assertSame('rezfusion-stars-rating.js', Assets::rezfusionStarsRatingScript());
    }

    public function testRezfusionFieldsValidationStyle()
    {
        $this->assertSame('rezfusion-fields-validation.css', Assets::rezfusionFieldsValidationStyle());
    }

    public function testRezfusionFieldsValidationScript()
    {
        $this->assertSame('rezfusion-fields-validation.js', Assets::rezfusionFieldsValidationScript());
    }

    public function testRezfusionModalStyle()
    {
        $this->assertSame('rezfusion-modal.css', Assets::rezfusionModalStyle());
    }

    public function testRezfusionModalScript()
    {
        $this->assertSame('rezfusion-modal.js', Assets::rezfusionModalScript());
    }

    public function testRezfusionReviewSubmitFormScript()
    {
        $this->assertSame('rezfusion-review-submit-form.js', Assets::rezfusionReviewSubmitFormScript());
    }

    public function testFeaturedPropertiesConfigurationComponentHandlerScript()
    {
        $this->assertSame('featured-properties-configuration-component-handler.js', Assets::featuredPropertiesConfigurationComponentHandlerScript());
    }

    public function testFeaturedPropertiesStyle()
    {
        $this->assertSame('featured-properties-configuration.css', Assets::featuredPropertiesStyle());
    }

    public function testQuickSearchStyle()
    {
        $this->assertSame('vr-quick-search.css', Assets::quickSearchStyle());
    }

    public function testPropertyCardFlagStyle()
    {
        $this->assertSame('property-card-flag.css', Assets::propertyCardFlagStyle());
    }

    public function testPropertyCardFlagScript()
    {
        $this->assertSame('property-card-flag.js', Assets::propertyCardFlagScript());
    }

    public function testReviewsModalHandlerScript()
    {
        $this->assertSame('rezfusion-reviews-modal-handler.js', Assets::reviewsModalHandlerScript());
    }

    public function testFavoritesStyle()
    {
        $this->assertSame('favorites.css', Assets::favoritesStyle());
    }

    public function testLocalBundleScript()
    {
        $this->assertSame('rezfusion-components/dist/main.js', Assets::localBundleScript());
    }

}
