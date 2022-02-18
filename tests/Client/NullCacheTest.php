<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\Cache;
use Rezfusion\Client\NullCache;

class NullCacheTest extends AbstractCacheTest
{
    protected $defaultMode = 0;

    protected function makeCache(): Cache
    {
        return new NullCache();
    }

    public function testSet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertFalse($this->Cache->set($key, $data));
    }

    public function testGet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertFalse($this->Cache->set($key, $data));
        $this->assertFalse($this->Cache->get($key));
    }

    public function testHas(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertFalse($this->Cache->has($key));
        $this->assertFalse($this->Cache->delete($key));
        $this->assertFalse($this->Cache->has($key));
    }

    public function testDelete(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertFalse($this->Cache->get($key));
        $this->assertFalse($this->Cache->delete($key));
        $this->assertFalse($this->Cache->get($key));
        $this->assertFalse($this->Cache->delete($key));
    }
}
