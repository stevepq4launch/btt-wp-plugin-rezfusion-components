<?php

/**
 * @file Tests for PluginConfiguration.
 */

namespace Rezfusion\Tests;

use Rezfusion\PluginConfiguration;

class PluginConfigurationTest extends BaseTestCase
{
    /**
     * @var PluginConfiguration
     */
    private $PluginConfiguration;

    public function setUp(): void
    {
        parent::setUp();
        $this->PluginConfiguration = PluginConfiguration::getInstance();
    }

    public function testRepositoryURL_IsNotEmpty()
    {
        $this->assertNotEmpty($this->PluginConfiguration->repositoryURL());
    }

    public function testRepositoryTokenIsNotEmpty()
    {
        $this->assertNotEmpty($this->PluginConfiguration->repositoryToken());
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf(PluginConfiguration::class, PluginConfiguration::getInstance());
    }
}
