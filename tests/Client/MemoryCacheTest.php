<?php

namespace Rezfusion\Tests\Cache;

use Rezfusion\Client\Cache;
use Rezfusion\Client\MemoryCache;

class MemoryCacheTest extends AbstractCacheTest
{
    /**
     * @var MemoryCache
     */
    protected $Cache;

    protected function makeCache(): Cache
    {
        return new MemoryCache();
    }

    public function testSet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertNull($this->Cache->set($key, $data));
    }

    public function testGet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertNull($this->Cache->set($key, $data));
        $this->assertSame($data, $this->Cache->get($key));
    }

    public function testHas(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertTrue($this->Cache->has($key));
        $this->assertNull($this->Cache->delete($key));
        $this->assertFalse($this->Cache->has($key));
    }

    public function testDelete(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertSame($data, $this->Cache->get($key));
        $this->assertNull($this->Cache->delete($key));
        $this->assertNull($this->Cache->get($key));
        $this->assertNull($this->Cache->delete($key));
    }

    public function testGetMemoryCache(): void
    {
        $expect = [
            $this->testKey => $this->testData
        ];
        $this->Cache->set($this->testKey, $this->testData);
        $this->assertSame($expect, $this->Cache->getMemoryCache());
    }
}
