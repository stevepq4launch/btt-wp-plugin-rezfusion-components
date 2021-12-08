<?php

namespace Rezfusion\Tests\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\ConfigurationStorageInterface;
use Rezfusion\Configuration\ConfigurationStorage\JSON_ConfigurationStorage;
use Rezfusion\Tests\BaseTestCase;

class JSON_ConfigurationStorageTest extends BaseTestCase
{
    const CONFIGURATION_FILENAME = './json-storage-test.json';

    /**
     * @var ConfigurationStorageInterface
     */
    private $ConfigurationStorage;

    private function configurationFilename(): string
    {
        return static::CONFIGURATION_FILENAME;
    }

    public function setUp(): void
    {
        parent::setUp();
        $filename = $this->configurationFilename();
        $this->assertNotEmpty($filename);
        if (file_exists($filename)) {
            unlink($filename);
        }
        $configuration = [
            'testKey' => 'testValue'
        ];
        file_put_contents($filename, json_encode($configuration));
        $this->ConfigurationStorage = new JSON_ConfigurationStorage($filename);
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
        $configurationFromFile = json_decode(file_get_contents($this->configurationFilename()), true);
        $this->assertSame([
            'testKey' => 'testValue',
            'testKey2' => 'testValue2'
        ], $configurationFromFile);
    }
}
