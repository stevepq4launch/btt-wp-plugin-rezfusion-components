<?php

namespace Rezfusion\Tests;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DeleteDataService;

class DeleteDataServiceTest extends BaseTestCase
{
    public function testLockedRun()
    {
        DeleteDataService::lock();
        $this->expectException(\Error::class);
        (new DeleteDataService())->run();
    }

    public function testRun()
    {
        DeleteDataService::unlock();
        Plugin::refreshData();
        $ItemRepository = new ItemRepository((new API_ClientFactory())->make());
        $this->assertGreaterThan(1, count($ItemRepository->getAllItemsIds()));
        (new DeleteDataService())->run();
        $this->assertCount(0, $ItemRepository->getAllItemsIds());
    }
}
