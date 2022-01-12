<?php

namespace Rezfusion\Tests\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;
use Rezfusion\Configuration\ConfigurationStorage\DatabaseConfigurationStorage;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Tests\BaseTestCase;

class DatabaseConfigurationStorageTest extends BaseTestCase
{
    const CONFIGURATION_OPTION_NAME = 'configuration-storage-test';

    /**
     * @var ConfigurationStorageInterface
     */
    private $ConfigurationStorage;

    private function configurationOptionName(): string
    {
        return static::CONFIGURATION_OPTION_NAME;
    }

    public function setUp(): void
    {
        parent::setUp();
        $configurationOptionName = $this->configurationOptionName();
        $this->assertNotEmpty($configurationOptionName);
        OptionManager::delete($configurationOptionName);
        $configuration = [
            'testKey' => 'testValue'
        ];
        OptionManager::update($configurationOptionName, json_encode($configuration));
        $this->ConfigurationStorage = new DatabaseConfigurationStorage($configurationOptionName);
    }

    public function testLoadConfiguration()
    {
        $config = $this->ConfigurationStorage->loadConfiguration();
        $this->assertIsObject($config);
        $array = (array) $config;
        $this->assertIsArray($array);
        $this->assertArrayHasKey('testKey', $array);
        $this->assertSame('testValue', $array['testKey']);
    }

    /**
     * @depends testLoadConfiguration
     */
    public function testSaveConfiguration()
    {
        $configuration = $this->ConfigurationStorage->loadConfiguration();
        $configuration->testKey2 = 'testValue2';
        $this->ConfigurationStorage->saveConfiguration($configuration);
        $configurationFromDatabase = $this->ConfigurationStorage->loadConfiguration();
        $this->assertSame([
            'testKey' => 'testValue',
            'testKey2' => 'testValue2'
        ], (array) $configurationFromDatabase);
    }
}
