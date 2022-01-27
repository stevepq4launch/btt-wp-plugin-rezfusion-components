<?php

namespace Rezfusion\Tests\Service;

use Rezfusion\Service\RemoveRedundantCategoriesService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class RemoveRedundantCategoriesServiceTest extends BaseTestCase
{
    public function testGetKeysFromSourceCategories(): void
    {
        $RemoveRedundantCategoriesService = new RemoveRedundantCategoriesService;
        $categories = json_decode(json_encode([
            'data' =>  [
                'categoryInfo' =>  [
                    'categories' =>  [
                        [
                            'values' =>  [
                                ['id' => 1000],
                                ['id' => ''],
                                ['id' => 1001],
                                ['id' => null],
                                ['id' => 1002]
                            ]
                        ]
                    ]
                ]
            ]
        ]));
        $keys = TestHelper::callClassMethod($RemoveRedundantCategoriesService, 'getKeysFromSourceCategories', [$categories]);
        $this->assertCount(3, $keys);
    }
}
