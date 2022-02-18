<?php

namespace Rezfusion\Tests\Client;

use Rezfusion\Client\Cache;
use Rezfusion\Client\FileCache;
use RuntimeException;

class FileCacheTest extends AbstractCacheTest
{
    private function cacheFile(): string
    {
        return './file-cache-test.json';
    }

    private function removeCacheFile(): void
    {
        $cacheFile = $this->cacheFile();
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    private function createCacheFile(): void
    {
        $cacheFile = $this->cacheFile();
        touch($cacheFile);
        if (!file_exists($this->cacheFile())) {
            throw new RuntimeException('Cache file was not created.');
        }
    }

    protected function makeCache(): Cache
    {
        $this->removeCacheFile();
        $this->createCacheFile();
        return new FileCache($this->cacheFile());
    }

    public function testCreateWithInvalidFilePath(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid file.');
        new FileCache(null);
    }

    public function testSetFail(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Key %s was already saved.', $key));
        $this->Cache->set($key, $data);
        $this->Cache->set($key, $data);
    }

    public function testSet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertSame($data, $this->Cache->set($key, $data));
    }

    public function testGet(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->assertSame($data, $this->Cache->set($key, $data));
        $this->assertSame($data, $this->Cache->get($key));
    }

    public function testDelete(): void
    {
        $key = $this->testKey;
        $data = $this->testData;
        $this->Cache->set($key, $data);
        $this->assertSame($data, $this->Cache->get($key));
        $this->assertTrue($this->Cache->delete($key));
        $this->assertNull($this->Cache->get($key));
        $this->assertFalse($this->Cache->delete($key));
    }
}
