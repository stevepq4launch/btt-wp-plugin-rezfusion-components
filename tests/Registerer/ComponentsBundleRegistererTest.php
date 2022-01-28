<?php

namespace Rezfusion\Tests\Registerer;

use Exception;
use ReflectionClass;
use Rezfusion\Actions;
use Rezfusion\Configuration\ConfigurationStorage\NullConfigurationStorage;
use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Plugin;
use Rezfusion\Provider\CustomHubConfigurationProvider;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Registerer\ComponentsBundleRegisterer;
use Rezfusion\Registerer\RegistererInterface;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\BaseTestCase;

class ComponentsBundleRegistererTest extends BaseTestCase
{
    private function makeComponentsBundleRegisterer(): ComponentsBundleRegisterer
    {
        $ComponentsBundleRegisterer = new ComponentsBundleRegisterer(
            Plugin::getInstance()->getAssetsRegisterer(),
            OptionsHandlerProvider::getInstance()
        );
        $this->assertInstanceOf(ComponentsBundleRegisterer::class, $ComponentsBundleRegisterer);
        $this->assertInstanceOf(RegistererInterface::class, $ComponentsBundleRegisterer);
        return $ComponentsBundleRegisterer;
    }

    public function testDoubleRegistration()
    {
        $ComponentsBundleRegisterer = $this->makeComponentsBundleRegisterer();
        $ComponentsBundleRegisterer = new ComponentsBundleRegisterer(
            Plugin::getInstance()->getAssetsRegisterer(),
            OptionsHandlerProvider::getInstance()
        );
        $ComponentsBundleRegisterer->register();
        $this->assertTrue(true);
    }

    public function testConfigurationVariableName()
    {
        $ComponentsBundleRegisterer = $this->makeComponentsBundleRegisterer();
        $configurationVariableName = $ComponentsBundleRegisterer->configurationVariableName();
        $this->assertNotEmpty('REZFUSION_COMPONENTS_BUNDLE_CONF', $configurationVariableName);
    }

    public function testUserDefinedConfigurationVariableName()
    {
        $ComponentsBundleRegisterer = $this->makeComponentsBundleRegisterer();
        $userDefinedConfigurationVariableName = $ComponentsBundleRegisterer->userDefinedConfigurationVariableName();
        $this->assertNotEmpty('REZFUSION_COMPONENTS_CONF', $userDefinedConfigurationVariableName);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRegisterWithInvalidHubConfiguration(): void
    {
        $this->refreshDatabaseDataAfterTest();
        DeleteDataService::unlock();
        (new DeleteDataService)->run();
        $this->setOutputCallback(function () {
        });
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid components URL./Invalid API key.');
        $class = new ReflectionClass(CustomHubConfigurationProvider::class);
        $property = $class->getProperty('Instance');
        $property->setAccessible(true);
        $CustomConfiguration = new HubConfiguration('', new NullConfigurationStorage());
        $property->setValue($CustomConfiguration);
        $ComponentsBundleRegisterer = $this->makeComponentsBundleRegisterer();
        $ComponentsBundleRegisterer->register();
        do_action(Actions::wpHead());
    }
}
