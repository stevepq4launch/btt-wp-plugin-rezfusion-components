<?php

/**
 * @file Tests for Plugin.
 */

namespace Rezfusion\Tests;

use ReflectionClass;
use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Factory\PluginFactory;
use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DeleteDataService;

class PluginTest extends BaseTestCase
{
    /**
     * @var Plugin
     */
    private $Plugin;

    public function setUp(): void
    {
        parent::setUp();
        $this->Plugin = (new PluginFactory)->make();
    }

    public function testPluginCreation(): void
    {
        $PluginReflectionClass = new ReflectionClass(Plugin::class);
        $InstanceProperty = $PluginReflectionClass->getProperty('instance');
        $InstanceProperty->setAccessible(true);
        $InstanceProperty->setValue(null);
        $Plugin = Plugin::getInstance();
        $this->assertInstanceOf(Plugin::class, $Plugin);
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(Plugin::class, $this->Plugin);
    }

    public function testPluginName(): void
    {
        $this->assertSame($this->Plugin->getPluginName(), 'Rezfusion');
    }

    public function testBundleScriptHandleName(): void
    {
        $componentsBundleURL = get_rezfusion_option(Options::componentsBundleURL());
        $this->assertNotEmpty($componentsBundleURL);
        $handle = $this->Plugin->getAssetsRegisterer()->handleScriptURL($componentsBundleURL);
        $this->assertSame('assets-rezfusion-com-base-v1-bundle-js', $handle);
    }

    public function testRefreshData(): void
    {
        DeleteDataService::unlock();
        (new DeleteDataService)->run();
        $ItemRepository = (new ItemRepository((new API_ClientFactory())->make()));
        $this->assertCount(0, $ItemRepository->getAllItemsIds());
        $this->Plugin->refreshData();
        $this->assertGreaterThan(1, count($ItemRepository->getAllItemsIds()));
    }

    public function testGetAssetsRegisterer(): void
    {
        $this->assertInstanceOf(AssetsRegistererInterface::class, $this->Plugin->getAssetsRegisterer());
        $this->assertInstanceOf(AssetsRegisterer::class, $this->Plugin->getAssetsRegisterer());
    }
}
