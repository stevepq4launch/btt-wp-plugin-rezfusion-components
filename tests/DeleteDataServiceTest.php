<?php

namespace Rezfusion\Tests;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Tests\TestHelper\PropertiesHelper;

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
        $this->refreshDatabaseDataAfterTest();
        DeleteDataService::unlock();
        $ItemRepository = new ItemRepository((new API_ClientFactory())->make());
        $this->assertGreaterThan(PropertiesHelper::minPropertiesCountInHub(), count($ItemRepository->getAllItemsIds()));
        (new DeleteDataService())->run();
        $this->assertCount(0, $ItemRepository->getAllItemsIds());
    }
}
