<?php

namespace Rezfusion\Tests\Configuration;

use Rezfusion\Actions;
use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Options;
use Rezfusion\Tests\BaseTestCase;

class RemoteConfigurationStorageTest extends BaseTestCase
{
    /**
     * @var string
     */
    private $hubConfigurationClass;

    /**
     * @var ConfigurationStorageInterface
     */
    private $ConfigurationStorage;

    public function setUp(): void
    {
        parent::setUp();
        $this->hubConfigurationClass = HubConfiguration::class;
        $this->ConfigurationStorage = new RemoteConfigurationStorage(
            get_rezfusion_option(Options::componentsURL()),
            $this->hubConfigurationClass
        );
    }

    public function testLoadConfiguration()
    {
        $configuration = json_decode(json_encode($this->ConfigurationStorage->loadConfiguration()), true);
        $this->assertIsArray($configuration);
        $this->assertNotEmpty($configuration);
        $this->assertArrayHasKey('hub_configuration', $configuration);
        $this->assertArrayHasKey($this->hubConfigurationClass::themeURL_Key(), $configuration);
        $this->assertArrayHasKey($this->hubConfigurationClass::fontsURL_Key(), $configuration);
        $this->assertArrayHasKey($this->hubConfigurationClass::componentsBundleURL_Key(), $configuration);
        $this->assertArrayHasKey($this->hubConfigurationClass::componentsCSS_URL_Key(), $configuration);
        $this->assertSame(
            get_rezfusion_option(Options::hubChannelURL()),
            $configuration['hub_configuration']['settings']['components']['SearchProvider']['channels']
        );
    }

    public function testSaveConfiguration()
    {
        $this->assertEmpty($this->ConfigurationStorage->saveConfiguration([]));
    }

    public function testLoadConfigurationWithEmptyURL()
    {
        $this->setOutputCallback(function ($html) {
            $this->assertStringContainsString('<div class="notice notice-error is-dismissible">', $html);
            $this->assertStringContainsString('<p>No hub configuration available.&nbsp;&nbsp;Set components URL <a href="/wp-admin/admin.php?page=rezfusion_components_config">here</a>.</p>', $html);
        });
        $ConfigurationStorage = new RemoteConfigurationStorage('', $this->hubConfigurationClass);
        $ConfigurationStorage->loadConfiguration();
        do_action(Actions::adminNotices());
    }
}
