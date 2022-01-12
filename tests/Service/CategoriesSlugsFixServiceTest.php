<?php

namespace Rezfusion\Tests\Service;

use Rezfusion\Service\CategoriesSlugsFixService;
use Rezfusion\Tests\BaseTestCase;
use RuntimeException;

class CategoriesSlugsFixServiceTest extends BaseTestCase
{
    private function doTestFix($categories)
    {
        return (new CategoriesSlugsFixService())->fix($categories);
    }

    public function testFix(): void
    {
        $categories = [
            (object) [
                'name' => 'test-category'
            ],
            (object) [
                'name' => 'test-category'
            ],
            (object) [
                'name' => 'test-category'
            ]
        ];
        $this->doTestFix($categories);
        $this->assertIsArray($categories);
        $this->assertCount(3, $categories);
        $this->assertSame('test-category', $categories[0]->slug);
        $this->assertSame('test-category-2', $categories[1]->slug);
        $this->assertSame('test-category-3', $categories[2]->slug);
    }

    public function testFixWithInvalidCategoryName(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Category doesn't have name key.");
        $this->doTestFix([
            (object) [
                'invalidKey' => false
            ]
        ]);
    }
}
