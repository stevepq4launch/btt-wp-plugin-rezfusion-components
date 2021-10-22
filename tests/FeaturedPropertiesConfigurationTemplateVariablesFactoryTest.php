<?php

namespace Rezfusion\Tests;

use Rezfusion\Factory\FeaturedPropertiesConfigurationTemplateVariablesFactory;
use Rezfusion\Plugin;

class FeaturedPropertiesConfigurationTemplateVariablesFactoryTest extends BaseTestCase
{
    public function testMake()
    {
        Plugin::refreshData();
        $Factory = new FeaturedPropertiesConfigurationTemplateVariablesFactory();
        $templateVariables = $Factory->make();
        $this->assertIsArray($templateVariables);
        $this->assertNotEmpty($templateVariables);
        $this->assertArrayHasKey('propertiesDataSource', $templateVariables);
        $this->assertGreaterThan(1, $templateVariables['propertiesDataSource']);
    }
}
