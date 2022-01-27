<?php

namespace Rezfusion\Tests\Provider;

use ReflectionClass;
use Rezfusion\OptionsHandler;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Tests\BaseTestCase;

class OptionsHandlerProviderTest extends BaseTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGetInstance(): void
    {
        $OptionsHandler = OptionsHandlerProvider::getInstance();
        $this->assertInstanceOf(OptionsHandler::class, $OptionsHandler);
    }

    public function testConstruct(): void
    {
        $class = new ReflectionClass(OptionsHandlerProvider::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        $this->assertNull($constructor->invoke($object));
    }
}
