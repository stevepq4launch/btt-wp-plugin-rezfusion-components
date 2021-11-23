<?php

/**
 * @file Tests for OptionManager.
 */

namespace Rezfusion\Tests;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use TypeError;

class OptionManagerTest extends BaseTestCase
{

    const TEST_OPTION_NAME = 'test-option';

    public function testGet()
    {
        $this->assertSame(OptionManager::get(Options::hubChannelURL()), 'https://www.rezfusionhubdemo.com');
    }

    public function testUpdate()
    {
        $optionName = static::TEST_OPTION_NAME;
        $testValue = 'this-is-test-value';
        $this->assertTrue(OptionManager::update($optionName, $testValue));
        $value = OptionManager::get($optionName);
        $this->assertNotEmpty($value);
        $this->assertSame($value, $testValue);
    }

    public function testDelete()
    {
        $optionName = static::TEST_OPTION_NAME;
        $this->assertTrue(OptionManager::update($optionName, 'this-is-test-value'));
        $this->assertTrue(OptionManager::delete($optionName));
        $this->assertEmpty(OptionManager::get($optionName));
    }

    public function testInvalidOptionUpdate()
    {
        $this->expectException(TypeError::class);
        OptionManager::update(null, '');
    }

    public function testRedundantUpdate()
    {
        $originalValue = 'this-is-test-value';
        $this->assertTrue(OptionManager::update(static::TEST_OPTION_NAME, $originalValue));
        $value = OptionManager::get(static::TEST_OPTION_NAME);
        $this->assertNotEmpty($value);
        $this->assertSame($originalValue, $value);
        $this->assertFalse(OptionManager::update(static::TEST_OPTION_NAME, $value));
    }

    public function tearDown(): void
    {
        OptionManager::delete(static::TEST_OPTION_NAME);
    }
}
