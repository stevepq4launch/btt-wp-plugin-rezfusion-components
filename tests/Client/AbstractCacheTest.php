<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\Cache;
use Rezfusion\Tests\BaseTestCase;

abstract class AbstractCacheTest extends BaseTestCase
{
    /**
     * @var Cache
     */
    protected $Cache = null;

    protected $defaultMode = 3;

    protected $testKey = 'test-key-1';

    protected $testData = ['test-value-1'];

    abstract protected function makeCache(): Cache;

    public function setUp(): void
    {
        parent::setUp();
        $this->Cache = $this->makeCache();
    }

    public function testRead(): void
    {
        $this->assertSame(1, $this->Cache::MODE_READ);
    }

    public function testWrite(): void
    {
        $this->assertSame(2, $this->Cache::MODE_WRITE);
    }

    public function testMode(): void
    {
        $this->assertSame($this->defaultMode, $this->Cache->getMode());
    }

    public function testSet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertTrue($this->Cache->set($key, $data));
    }

    public function testGet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertTrue($this->Cache->set($key, $data));
        $this->assertSame($data, $this->Cache->get($key));
    }

    public function testHas(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertTrue($this->Cache->has($key));
        $this->assertTrue($this->Cache->delete($key));
        $this->assertFalse($this->Cache->has($key));
    }

    public function testDelete(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertSame($data, $this->Cache->get($key));
        $this->assertTrue($this->Cache->delete($key));
        $this->assertFalse($this->Cache->get($key));
        $this->assertFalse($this->Cache->delete($key));
    }
}
