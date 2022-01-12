<?php

namespace Rezfusion\Tests\Query;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Query\FindPropertyNameByPostIdQuery;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Tests\BaseTestCase;

class FindPropertyNameByPostIdQueryTest extends BaseTestCase
{
    public function testExecute()
    {
        $ItemRepository = new ItemRepository((new API_ClientFactory)->make());
        $items = $ItemRepository->getAllItems();
        $this->assertIsArray($items);
        $this->assertGreaterThan(0, $items);
        $item = $items[0];
        $postId = $item['post_id'];
        $this->assertNotEmpty($postId);
        $expectedPostTitle = $item['post_title'];
        $this->assertNotEmpty($expectedPostTitle);
        $postTitle = (new FindPropertyNameByPostIdQuery())->execute($postId);
        $this->assertSame($expectedPostTitle, $postTitle);
    }
}
