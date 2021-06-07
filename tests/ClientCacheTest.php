<?php
/**
 * @file - Test the cache/client integration.
 */

namespace Rezfusion\Tests;

use Rezfusion\Client\Cache;
use Rezfusion\Client\Client;
use Rezfusion\Client\MemoryCache;

class ClientCacheTest extends BaseTestCase {

  /**
   * @var Client
   */
  protected $mockClient;

  /**
   * @var \Rezfusion\Client\MemoryCache
   */
  protected $mockCache;

  /**
   * Set up some basic instances that verify the behavior in `call` in the real
   * client implementation.
   */
  public function setUp():void {
    parent::setUp();
    $this->mockCache = new MemoryCache();

    // Mock a client instance. We don't care about the contents of the request
    // or response. We care that we generate consistent keys and that our
    // cache handling is correct.
    $this->mockClient = $this->getMockForAbstractClass(Client::class, ['fake/path', 'fakeuri', $this->mockCache]);
    $this->mockClient->method('request')
      ->willReturn('things');

    // NOTE: We verify how many times this function is called
    // to be sure that we are skipping calls.
    $this->mockClient->expects($this->exactly(4))
      ->method('request');
  }

  /**
   * Test that the cache read/write modes interact with the client class correctly.
   */
  public function testCacheModes() {

    // Get the default READ | WRITE mode.
    $default = $this->mockCache->getMode();

    // Test that we write by default. Clean up after.
    $this->mockClient->call('fooQuery', ['variables' => 'foo']);
    $key1 = Client::cacheKey('fooQuery', ['variables' => 'foo']);
    $this->assertTrue($this->mockCache->has($key1));
    $this->mockCache->delete($key1);

    // Set the mode to read and check that it doesn't write a key.
    $this->mockCache->setMode(Cache::MODE_READ);
    $this->mockClient->call('fooQuery', ['variables' => 'foo']);
    $this->assertEmpty($this->mockCache->has($key1));

    // Set to write and rewrite the key.
    $this->mockCache->setMode(Cache::MODE_WRITE);
    $this->mockClient->call('fooQuery', ['variables' => 'foo']);
    $this->assertNotEmpty($this->mockCache->has($key1));

    // Add a new entry.
    $this->mockClient->call('fooQuery2', ['variables' => 'bar']);
    $key2 = Client::cacheKey('fooQuery2', ['variables' => 'bar']);
    $this->assertNotEmpty($this->mockCache->has($key2));
    $this->assertEquals(2, count($this->mockCache->getMemoryCache()));

    // We should have made 4 calls to `request` and then
    // ALL these calls should be cached. Set the cache
    // mode back to default and fire away.
    $this->mockCache->setMode($default);
    $this->mockClient->call('fooQuery', ['variables' => 'foo']);
    $this->mockClient->call('fooQuery2', ['variables' => 'bar']);
    $this->mockClient->call('fooQuery2', ['variables' => 'bar']);
    $this->mockClient->call('fooQuery2', ['variables' => 'bar']);
    $this->mockClient->call('fooQuery2', ['variables' => 'bar']);

  }

}
