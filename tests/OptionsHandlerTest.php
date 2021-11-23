<?php

/**
 * @file Tests for OptionsHandler.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Exception\InvalidOptionNameException;
use Rezfusion\Options;
use Rezfusion\OptionsHandler;
use Rezfusion\PluginConfiguration;

class OptionsHandlerTest extends BaseTestCase
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
        $this->OptionsHandler = new OptionsHandler($this->HubConfiguration, $this->PluginConfiguration);
    }

    public function testGetHubConfigurationMap()
    {
        $hubConfigurationMap = $this->OptionsHandler->getHubConfigurationMap();
        $this->assertIsArray($hubConfigurationMap);
        $this->assertCount(14, $hubConfigurationMap);
    }

    public function testMakePluginConfigurationMap()
    {
        $pluginConfigurationMap = $this->OptionsHandler->getPluginConfigurationMap();
        $this->assertIsArray($pluginConfigurationMap);
        $this->assertCount(2, $pluginConfigurationMap);
    }

    public function testValidateOption()
    {
        $this->expectException(InvalidOptionNameException::class);
        $this->OptionsHandler->getOption('');
    }

    public function testInvalidGetOption()
    {
        $this->expectException(\Exception::class);
        $this->OptionsHandler->getOption('unknown-option');
    }

    public function testGetOptionDefault()
    {
        $this->assertSame('-default-', $this->OptionsHandler->getOption(Options::featuredPropertiesBedsLabel(), '-default-'));
    }

    public function testUpdateOption()
    {
        $optionName = Options::featuredPropertiesBathsLabel();
        $expected = 'bathsLabelTest';
        $this->assertTrue($this->OptionsHandler->updateOption($optionName, time()));
        $this->assertTrue($this->OptionsHandler->updateOption($optionName, $expected));
        $this->assertSame($expected, $this->OptionsHandler->getOption($optionName));
    }
}
