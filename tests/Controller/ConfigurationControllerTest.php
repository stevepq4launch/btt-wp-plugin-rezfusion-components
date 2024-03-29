<?php

namespace Rezfusion\Tests\Controller;

use Rezfusion\Configuration\ConfigurationStorage\NullConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationUpdater;
use Rezfusion\Controller\ConfigurationController;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\REST_Helper;

class ConfigurationControllerTest extends BaseTestCase
{
    /**
     * @param HubConfiguration $HubConfiguration
     * @param HubConfigurationUpdater $HubConfigurationUpdater
     * 
     * @return ConfigurationController
     */
    private function makeConfigurationController(
        HubConfiguration $HubConfiguration,
        HubConfigurationUpdater $HubConfigurationUpdater
    ): ConfigurationController {
        return new ConfigurationController($HubConfiguration, $HubConfigurationUpdater);
    }

    /**
     * Creates a new instance of HubConfiguration for test purpose.
     * @return HubConfiguration
     */
    private function makeHubConfiguration(): HubConfiguration
    {
        return new HubConfiguration(
            OptionManager::get(Options::componentsURL()),
            new NullConfigurationStorage(OptionManager::get(Options::componentsURL()), HubConfiguration::class)
        );
    }

    public function testReloadConfigurationWithInvalidHubConfigurationUpdater(): void
    {
        $HubConfiguration = $this->makeHubConfiguration();
        $HubConfigurationUpdater = $this->createMock(HubConfigurationUpdater::class);
        $HubConfigurationUpdater->method('update')->willReturn(false);
        $Controller = $this->makeConfigurationController($HubConfiguration, $HubConfigurationUpdater);
        $response = $Controller->reloadConfiguration(REST_Helper::makeRequest());
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame('Update failed.', $response->data);
    }

    public function testReloadConfiguration(): void
    {
        $HubConfiguration = $this->makeHubConfiguration();
        $Controller = $this->makeConfigurationController(
            $HubConfiguration,
            new HubConfigurationUpdater(
                $HubConfiguration,
                new NullConfigurationStorage
            )
        );
        $response = $Controller->reloadConfiguration(REST_Helper::makeRequest());
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);
        $this->assertSame(true, $response->data);
    }

    public function testLoadConfigurationFail(): void
    {
        $exceptionMessage = "Configuration load failed.";
        $HubConfiguration = $this->createMock(HubConfiguration::class);
        $HubConfiguration->method('getConfiguration')->willThrowException(
            new \Exception($exceptionMessage)
        );
        $Controller = $this->makeConfigurationController(
            $HubConfiguration,
            new HubConfigurationUpdater(
                $HubConfiguration,
                new NullConfigurationStorage
            )
        );
        $response = $Controller->loadConfiguration(REST_Helper::makeRequest());
        $this->assertIsObject($response);
        $this->assertSame(400, $response->status);
        $this->assertSame($exceptionMessage, $response->data);
    }

    public function testLoadConfiguration(): void
    {
        $HubConfiguration = $this->makeHubConfiguration();
        $Controller = $this->makeConfigurationController(
            $HubConfiguration,
            new HubConfigurationUpdater(
                $HubConfiguration,
                new NullConfigurationStorage
            )
        );
        $response = $Controller->loadConfiguration(REST_Helper::makeRequest());
        $this->assertIsObject($response);
        $this->assertSame(200, $response->status);
        $this->assertSame(null, $response->data);
    }
}
