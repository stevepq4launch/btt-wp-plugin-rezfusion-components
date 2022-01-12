<?php

namespace Rezfusion\Tests;

use RezfusionAutoloader;

class AutoloaderTest extends BaseTestCase
{
    public function testAddNamespace(): void
    {
        $RezfusionAutoloader = new RezfusionAutoloader;
        $Reflection = new \ReflectionClass($RezfusionAutoloader);
        $PrefixesProperty = $Reflection->getProperty('prefixes');
        $PrefixesProperty->setAccessible(true);
        $RezfusionAutoloader->addNamespace('rzf1', 'test1');
        $RezfusionAutoloader->addNamespace('rzf1', 'test2');
        $RezfusionAutoloader->addNamespace('rzf1', 'test3', true);
        $RezfusionAutoloader->addNamespace('rzf2', 'test1', true);
        $RezfusionAutoloader->addNamespace('', 'test1', true);
        $prefixes = $PrefixesProperty->getValue($RezfusionAutoloader);
        $this->assertIsArray($prefixes);
        $this->assertCount(3, $prefixes);
        $this->assertSame('test3/', $prefixes['rzf1\\'][0]);
        $this->assertSame('test1/', $prefixes['rzf1\\'][1]);
        $this->assertSame('test2/', $prefixes['rzf1\\'][2]);
        $this->assertSame('test1/', $prefixes['rzf2\\'][0]);
        $this->assertSame('test1/', $prefixes['\\'][0]);
        $RezfusionAutoloader->register();
    }

    public function testLoadClassWithInvalidFile(): void
    {
        $RezfusionAutoloader = new RezfusionAutoloader();
        $RezfusionAutoloader->addNamespace('\\RezfusionTest', '');
        $this->assertFalse($RezfusionAutoloader->loadClass('RezfusionTest\Invalid'));
    }
}
