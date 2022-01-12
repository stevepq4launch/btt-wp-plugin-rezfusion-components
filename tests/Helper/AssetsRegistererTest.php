<?php

namespace Rezfusion\Tests\Helper;

use Rezfusion\Helper\AssetsRegisterer;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class AssetsRegistererTest extends BaseTestCase
{
    const INVALID_ASSET_TYPE = 'invalid-type';

    /**
     * @var TestableAssetsRegisterer
     */
    private $AssetsRegisterer;

    private function invalidAssetType(): string
    {
        return static::INVALID_ASSET_TYPE;
    }

    private function callMethod($method = '', array $arguments = [])
    {
        return TestHelper::callClassMethod($this->AssetsRegisterer, $method, $arguments);
    }

    private function expectInvalidRegistererType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(AssetsRegisterer::class . ": Invalid registerer type.");
    }

    private function callHandle($handle = '', $source = '', $type = ''): string
    {
        return $this->callMethod('handle', [$handle, $source, $type]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->AssetsRegisterer = new AssetsRegisterer();
    }

    public function testScript(): void
    {
        $this->assertSame('script', $this->AssetsRegisterer::script());
    }

    public function testStyle(): void
    {
        $this->assertSame('style', $this->AssetsRegisterer::style());
    }

    public function testHandleWithInvalidType(): void
    {
        $this->expectInvalidRegistererType();
        $this->callHandle('', $this->invalidAssetType());
    }

    public function testPrepareSourceURL_WithInvalidType(): void
    {
        $this->expectInvalidRegistererType();
        $this->callMethod('prepareSourceURL', ['', $this->invalidAssetType()]);
    }

    public function testHandleWithInvalidHandle(): void
    {
        $this->expectException(\Error::class);
        $this->expectErrorMessage('Handle is invalid.');
        $this->callHandle('', '', $this->AssetsRegisterer::script());
    }

    public function testHandleWithInvalidSource(): void
    {
        $this->expectException(\Error::class);
        $this->expectErrorMessage('Source is invalid.');
        $this->callHandle('test-handle', '', $this->AssetsRegisterer::script());
    }
}
