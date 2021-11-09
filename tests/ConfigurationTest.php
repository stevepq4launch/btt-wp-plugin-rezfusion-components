<?php

/**
 * @file Test if configuration returns valid values.
 */

namespace Rezfusion\Tests;

use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;

class ConfigurationTest extends BaseTestCase
{
    /**
     * @var HubConfiguration
     */
    private $HubConfiguration;

    public function setUp(): void
    {
        parent::setUp();
        $this->HubConfiguration = HubConfigurationProvider::getInstance();
    }

    public function testProductionEnvironmentName()
    {
        $this->assertSame($this->HubConfiguration::productionEnvironment(), 'prd');
    }

    public function testDevelopmentEnvironmentName()
    {
        $this->assertSame($this->HubConfiguration::developmentEnvironment(), 'dev');
    }

    public function testDefaultProductionBlueprintURL()
    {
        $this->assertSame($this->HubConfiguration::defaultProductionBlueprintURL(), 'https://blueprint.rezfusion.com/graphql');
    }

    public function testDefaultDevelopmentBlueprintURL()
    {
        $this->assertSame($this->HubConfiguration::defaultDevelopmentBlueprintURL(), 'https://blueprint.hub-stg.rezfusion.com/graphql');
    }

    public function testDefaultSPS_Domain()
    {
        $this->assertSame($this->HubConfiguration::defaultSPS_Domain(), 'https://checkout.rezfusion.com');
    }

    public function testThemeURL_Key()
    {
        $this->assertSame($this->HubConfiguration::themeURL_Key(), 'themeURL');
    }

    public function testFontsURL_Key()
    {
        $this->assertSame($this->HubConfiguration::fontsURL_Key(), 'fontsURL');
    }

    public function testMaxReviewsRatingIsInteger()
    {
        $this->assertIsInt($this->HubConfiguration->getMaxReviewRating());
    }

    public function testMaxReviewsRatingIsGreaterThanZero()
    {
        $this->assertGreaterThan(0, $this->HubConfiguration->getMaxReviewRating());
    }
}
