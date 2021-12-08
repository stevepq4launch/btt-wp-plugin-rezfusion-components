<?php

namespace Rezfusion\Tests;

use Rezfusion\Configuration\HubConfiguration;
use Rezfusion\Validator\HubConfigurationValidator;

class HubConfigurationValidatorTest extends BaseTestCase
{
    public function createNullReturningHubConfiguration()
    {
        $HubConiguration = $this->createMock(HubConfiguration::class);
        $HubConiguration->method('getValue')->willReturn(null);
        return $HubConiguration;
        $HubConiguration;
    }

    public function testValidationFail()
    {
        $Validator = new HubConfigurationValidator();
        $HubConfiguration = $this->createNullReturningHubConfiguration();
        $expectedErrors = [
            "Invalid channel domain/URL.",
            "Invalid components URL.",
            "Invalid blueprint URL.",
            "Invalid API key.",
            "Invalid SPS domain/URL."
        ];

        $validationResult = $Validator->validate($HubConfiguration);
        $errors = $Validator->getErrors();
        sort($expectedErrors);
        sort($errors);

        $this->assertFalse($validationResult);
        $this->assertCount(5, $expectedErrors);
        $this->assertCount(5, $errors);
        $this->assertSame($expectedErrors, $errors);
    }
}
