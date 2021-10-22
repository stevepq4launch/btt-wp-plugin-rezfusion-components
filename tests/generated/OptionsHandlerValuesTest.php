<?php

/**
 * @file Tests for OptionsHandler values.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\OptionsHandler;
use Rezfusion\PluginConfiguration;

class OptionsHandlerValuesTest extends BaseTestCase
{
    /**
     * @var HubConfiguration
     */
    private $HubConfiguration;

    /**
     * @var PluginConfiguration
     */
    private $PluginConfiguration;

    /**
     * @var OptionsHandler
     */
    private $OptionsHandler;

    public function setUp(): void
    {
        parent::setUp();
        $this->HubConfiguration = HubConfigurationProvider::getInstance();
        $this->PluginConfiguration = PluginConfiguration::getInstance();
        $this->OptionsHandler = new OptionsHandler($this->HubConfiguration,$this->PluginConfiguration);
    }

    public function testPluginConfigurationRepositoryURLValue()
    {
        $this->assertSame($this->PluginConfiguration->repositoryURL(), $this->OptionsHandler->getOption('rezfusion_hub_repository_url'));
    }

    public function testPluginConfigurationRepositoryTokenValue()
    {
        $this->assertSame($this->PluginConfiguration->repositoryToken(), $this->OptionsHandler->getOption('rezfusion_hub_repository_token'));
    }

    public function testHubConfigurationGetComponentsURLValue()
    {
        $this->assertSame($this->HubConfiguration->getComponentsURL(), $this->OptionsHandler->getOption('rezfusion_hub_folder'));
    }

    public function testHubConfigurationGetChannelURLValue()
    {
        $this->assertSame($this->HubConfiguration->getChannelURL(), $this->OptionsHandler->getOption('rezfusion_hub_channel'));
    }

    public function testHubConfigurationGetBookingConfirmationURLValue()
    {
        $this->assertSame($this->HubConfiguration->getBookingConfirmationURL(), $this->OptionsHandler->getOption('rezfusion_hub_conf_page'));
    }

    public function testHubConfigurationGetSPS_DomainValue()
    {
        $this->assertSame($this->HubConfiguration->getSPS_Domain(), $this->OptionsHandler->getOption('rezfusion_hub_sps_domain'));
    }

    public function testHubConfigurationGetFavoritesEnabledValue()
    {
        $this->assertSame($this->HubConfiguration->getFavoritesEnabled(), $this->OptionsHandler->getOption('rezfusion_hub_enable_favorites'));
    }

    public function testHubConfigurationGetMapAPI_KeyValue()
    {
        $this->assertSame($this->HubConfiguration->getMapAPI_Key(), $this->OptionsHandler->getOption('rezfusion_hub_google_maps_api_key'));
    }

    public function testHubConfigurationGetThemeURLValue()
    {
        $this->assertSame($this->HubConfiguration->getThemeURL(), $this->OptionsHandler->getOption('rezfusion_hub_theme'));
    }

    public function testHubConfigurationGetBlueprintURLValue()
    {
        $this->assertSame($this->HubConfiguration->getBlueprintURL(), $this->OptionsHandler->getOption('rezfusion_hub_blueprint_url'));
    }

    public function testHubConfigurationGetFontsURLValue()
    {
        $this->assertSame($this->HubConfiguration->getFontsURL(), $this->OptionsHandler->getOption('rezfusion_hub_fonts_url'));
    }

    public function testHubConfigurationGetEnvironmentValue()
    {
        $this->assertSame($this->HubConfiguration->getEnvironment(), $this->OptionsHandler->getOption('rezfusion_hub_env'));
    }

    public function testHubConfigurationGetMaxReviewRatingValue()
    {
        $this->assertSame($this->HubConfiguration->getMaxReviewRating(), $this->OptionsHandler->getOption('rezfusion_hub_max_review_rating'));
    }

    public function testHubConfigurationGetHubConfigurationArrayValue()
    {
        $this->assertSame($this->HubConfiguration->getHubConfigurationArray(), $this->OptionsHandler->getOption('rezfusion_hub_configuration'));
    }

    public function testHubConfigurationGetComponentsBundleURLValue()
    {
        $this->assertSame($this->HubConfiguration->getComponentsBundleURL(), $this->OptionsHandler->getOption('components_bundle_url'));
    }

    public function testHubConfigurationGetComponentsCSS_URLValue()
    {
        $this->assertSame($this->HubConfiguration->getComponentsCSS_URL(), $this->OptionsHandler->getOption('components_css_url'));
    }

}
