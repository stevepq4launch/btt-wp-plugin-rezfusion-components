<?php

namespace Rezfusion\Tests;

use Rezfusion\TestBuilder\TestBuilder;
use Rezfusion\Tests\TestHelper\TestHelper;

class TestBuilderTest extends BaseTestCase
{
    private function outputTestFilePath(): string
    {
        return __DIR__ . "/test-builder-1.php";
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $outputTestFilePath = $this->outputTestFilePath();
        if (file_exists($outputTestFilePath)) {
            unlink($outputTestFilePath);
        }
    }

    public function testBuild(): void
    {
        $TestBuilder = new TestBuilder;
        $file = $this->outputTestFilePath();
        $TestBuilder
            ->reset()
            ->withUse(['Rezfusion\Tests\BaseTestCase'])
            ->withNamespace('Rezfusion\Tests')
            ->withExtends('\Rezfusion\Tests\BaseTestCase')
            ->withOutputToFile($file)
            ->withDescription("TestBuilder Test #1.")
            ->withClassName("TestBuilderTest1")
            ->withCustomCallback([
                ['Test1', ['value-1', false]]
            ], function ($testName, $arguments) use ($TestBuilder) {
                return $TestBuilder->renderTestMethod(
                    'test' . $testName,
                    ["\$this->assertSame(" . $TestBuilder->renderArgumentsString($arguments) . ");"]
                );
            });
        $TestBuilder->withClassPreContent("    private \$info = '';");
        $TestBuilder->build();
        $this->assertFileExists($file);
    }

    public function testBuildWithInvalidFileName(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Invalid file.');
        $TestBuilder = new TestBuilder;
        $TestBuilder
            ->reset()
            ->withOutputToFile('');
        TestHelper::callClassMethod($TestBuilder, 'outputToFile');
    }
}
