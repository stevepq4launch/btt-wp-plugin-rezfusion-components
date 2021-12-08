<?php

namespace Rezfusion\Tests\Configuration;

use Rezfusion\Configuration\ConfigurationStorage\NullConfigurationStorage;
use Rezfusion\Tests\BaseTestCase;

class NullConfigurationStorageTest extends BaseTestCase
{
    /**
     * @var ConfigurationStorageInterface
     */
    private $ConfigurationStorage;

    public function setUp(): void
    {
        parent::setUp();
        $this->ConfigurationStorage = new NullConfigurationStorage();
    }

    public function testLoadConfiguration()
    {
        $this->assertEmpty($this->ConfigurationStorage->loadConfiguration());
    }

    public function testSaveConfiguration()
    {
        $this->assertEmpty($this->ConfigurationStorage->saveConfiguration([]));
    }
}
