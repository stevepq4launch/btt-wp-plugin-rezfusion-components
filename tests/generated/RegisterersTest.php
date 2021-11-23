<?php

/**
 * @file Tests for registerers.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Factory\RegisterersContainerFactory;
use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\OptionsHandler;
use Rezfusion\PluginConfiguration;
use Rezfusion\Registerer\RegistererInterface;

class RegisterersTest extends BaseTestCase
{
    /**
     * @var RegisterersContainer
     */
    private $RegisterersContainer;

    public function setUp(): void
    {
        parent::setUp();
        $this->RegisterersContainer = (new RegisterersContainerFactory(
            new AssetsRegisterer,
            new OptionsHandler(HubConfigurationProvider::getInstance(), PluginConfiguration::getInstance())
        ))->make();
    }

    public function testFunctionsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FunctionsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testFunctionsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FunctionsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\FunctionsRegisterer::class, $Registerer);
    }

    public function testFunctionsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FunctionsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testPostTypesRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PostTypesRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testPostTypesRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PostTypesRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\PostTypesRegisterer::class, $Registerer);
    }

    public function testPostTypesRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PostTypesRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testShortcodesRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ShortcodesRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testShortcodesRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ShortcodesRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\ShortcodesRegisterer::class, $Registerer);
    }

    public function testShortcodesRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ShortcodesRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testRewriteTagsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RewriteTagsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testRewriteTagsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RewriteTagsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\RewriteTagsRegisterer::class, $Registerer);
    }

    public function testRewriteTagsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RewriteTagsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testDelayedRewriteFlushRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\DelayedRewriteFlushRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testDelayedRewriteFlushRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\DelayedRewriteFlushRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\DelayedRewriteFlushRegisterer::class, $Registerer);
    }

    public function testDelayedRewriteFlushRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\DelayedRewriteFlushRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testPagesRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PagesRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testPagesRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PagesRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\PagesRegisterer::class, $Registerer);
    }

    public function testPagesRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PagesRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testSettingsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SettingsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testSettingsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SettingsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\SettingsRegisterer::class, $Registerer);
    }

    public function testSettingsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SettingsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testTemplateRedirectRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\TemplateRedirectRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testTemplateRedirectRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\TemplateRedirectRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\TemplateRedirectRegisterer::class, $Registerer);
    }

    public function testTemplateRedirectRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\TemplateRedirectRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testFontsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FontsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testFontsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FontsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\FontsRegisterer::class, $Registerer);
    }

    public function testFontsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FontsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testSessionRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SessionRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testSessionRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SessionRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\SessionRegisterer::class, $Registerer);
    }

    public function testSessionRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\SessionRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testFeaturedPropertiesConfigurationScriptsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FeaturedPropertiesConfigurationScriptsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testFeaturedPropertiesConfigurationScriptsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FeaturedPropertiesConfigurationScriptsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\FeaturedPropertiesConfigurationScriptsRegisterer::class, $Registerer);
    }

    public function testFeaturedPropertiesConfigurationScriptsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\FeaturedPropertiesConfigurationScriptsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testControllersRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ControllersRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testControllersRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ControllersRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\ControllersRegisterer::class, $Registerer);
    }

    public function testControllersRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ControllersRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testRezfusionHTML_ComponentsRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RezfusionHTML_ComponentsRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testRezfusionHTML_ComponentsRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RezfusionHTML_ComponentsRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\RezfusionHTML_ComponentsRegisterer::class, $Registerer);
    }

    public function testRezfusionHTML_ComponentsRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\RezfusionHTML_ComponentsRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testComponentsBundleRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ComponentsBundleRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testComponentsBundleRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ComponentsBundleRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\ComponentsBundleRegisterer::class, $Registerer);
    }

    public function testComponentsBundleRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\ComponentsBundleRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

    public function testPluginUpdateRegistererExists()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PluginUpdateRegisterer::class);
        $this->assertNotEmpty($Registerer);
    }

    public function testPluginUpdateRegistererInstance()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PluginUpdateRegisterer::class);
        $this->assertInstanceOf(\Rezfusion\Registerer\PluginUpdateRegisterer::class, $Registerer);
    }

    public function testPluginUpdateRegistererInterface()
    {
        $Registerer = $this->RegisterersContainer->find(\Rezfusion\Registerer\PluginUpdateRegisterer::class);
        $this->assertInstanceOf(RegistererInterface::class, $Registerer);
    }

}
