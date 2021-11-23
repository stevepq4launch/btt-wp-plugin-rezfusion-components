<?php

/**
 * @file Test if HubConfiguration values are not empty.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;

class HubConfigurationValuesNotEmptyTest extends BaseTestCase
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

    public function testProductionEnvironmentValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::productionEnvironment());
    }

    public function testDevelopmentEnvironmentValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::developmentEnvironment());
    }

    public function testDefaultProductionBlueprintURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::defaultProductionBlueprintURL());
    }

    public function testDefaultDevelopmentBlueprintURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::defaultDevelopmentBlueprintURL());
    }

    public function testDefaultSPS_DomainValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::defaultSPS_Domain());
    }

    public function testThemeURL_KeyValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::themeURL_Key());
    }

    public function testFontsURL_KeyValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::fontsURL_Key());
    }

    public function testComponentsBundleURL_KeyValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::componentsBundleURL_Key());
    }

    public function testComponentsCSS_URL_KeyValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration::componentsCSS_URL_Key());
    }

    public function testGetConfigurationURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getConfigurationURL());
    }

    public function testGetConfigurationValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getConfiguration());
    }

    public function testGetComponentsURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getComponentsURL());
    }

    public function testGetChannelURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getChannelURL());
    }

    public function testGetSPS_DomainValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getSPS_Domain());
    }

    public function testGetBookingConfirmationURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getBookingConfirmationURL());
    }

    public function testGetFavoritesEnabledValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getFavoritesEnabled());
    }

    public function testGetMapAPI_KeyValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getMapAPI_Key());
    }

    public function testGetItemsDetailsPathValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getItemsDetailsPath());
    }

    public function testGetThemeURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getThemeURL());
    }

    public function testGetEnvironmentValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getEnvironment());
    }

    public function testGetBlueprintURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getBlueprintURL());
    }

    public function testGetFontsURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getFontsURL());
    }

    public function testGetMaxReviewRatingValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getMaxReviewRating());
    }

    public function testGetComponentsBundleURLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getComponentsBundleURL());
    }

    public function testGetComponentsCSS_URLValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getComponentsCSS_URL());
    }

    public function testGetHubConfigurationArrayValueNotEmpty()
    {
        $this->assertNotEmpty($this->HubConfiguration->getHubConfigurationArray());
    }

}
