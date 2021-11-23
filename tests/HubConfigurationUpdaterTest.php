<?php

namespace Rezfusion\Tests;

use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;
use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Configuration\HubConfigurationUpdater;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\OptionsHandler;

class HubConfigurationUpdaterTest extends BaseTestCase
{
    /**
     * @var HubConfigurationUpdater
     */
    private $HubConfigurationUpdater;

    public function setUp(): void
    {
        parent::setUp();
        $this->HubConfiguration = HubConfigurationProvider::getInstance();
        $this->assertInstanceOf(HubConfiguration::class, $this->HubConfiguration);
        $this->ConfigurationStorage = new RemoteConfigurationStorage($this->HubConfiguration->getComponentsURL(), get_class($this->HubConfiguration));
        $this->assertInstanceOf(ConfigurationStorageInterface::class, $this->ConfigurationStorage);
        $this->assertInstanceOf(RemoteConfigurationStorage::class, $this->ConfigurationStorage);
        $this->HubConfigurationUpdater = new HubConfigurationUpdater(
            $this->HubConfiguration,
            $this->ConfigurationStorage
        );
    }

    public function testInstance()
    {
        $this->assertInstanceOf(HubConfigurationUpdater::class, $this->HubConfigurationUpdater);
    }

    public function testUpdate()
    {
        $this->HubConfiguration->setConfiguration([]);
        $currentConfiguration = $this->HubConfiguration->getConfiguration();
        $this->assertIsArray($currentConfiguration);
        $this->assertEmpty($currentConfiguration);
        $this->assertTrue($this->HubConfigurationUpdater->update());
        $currentConfiguration = $this->HubConfiguration->getConfiguration();
        $this->assertIsObject($currentConfiguration);
        $this->assertNotEmpty($currentConfiguration);
    }

    public function testInvalidUpdate()
    {
        $HubConfiguration = HubConfigurationProvider::getInstance();
        $this->assertInstanceOf(HubConfiguration::class, $HubConfiguration);
        $ConfigurationStorage = $this->createMock(\Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface::class);
        $ConfigurationStorage->method('loadConfiguration')->willThrowException(new \Exception);
        $this->assertInstanceOf(ConfigurationStorageInterface::class, $ConfigurationStorage);
        $HubConfigurationUpdater = new HubConfigurationUpdater($HubConfiguration, $ConfigurationStorage);
        $this->assertFalse($HubConfigurationUpdater->update());
    }
}
