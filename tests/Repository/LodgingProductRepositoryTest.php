<?php

namespace Rezfusion\Tests\Repository;

use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Options;
use Rezfusion\Repository\AbstractHubRepository;
use Rezfusion\Repository\LodgingProductRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingProductRepositoryTest extends BaseTestCase
{
    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
    }

    private function makeLodgingProductRepository(): LodgingProductRepository
    {
        return new LodgingProductRepository(
            (new API_ClientFactory())->make(),
            get_rezfusion_option(Options::hubChannelURL())
        );
    }

    public function testConstructor(): void
    {
        $LodgingProductRepository = $this->makeLodgingProductRepository();
        $this->assertInstanceOf(AbstractHubRepository::class, $LodgingProductRepository);
    }

    public function testFindByIdsWithSingleId(): void
    {
        $expectedPropertyID = 'SXRlbTo3MTA5';
        $propertyID = PropertiesHelper::getRandomPropertyId();
        $this->assertSame($expectedPropertyID, $propertyID);
        $LodgingProductRepository = $this->makeLodgingProductRepository();
        $result = $LodgingProductRepository->findByIds([$propertyID]);
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $item = $result[0];
        PropertiesHelper::assertPropertyItem($this, $item);
        $this->assertSame($expectedPropertyID, $item->item->id);
        $this->assertSame('102 A Shore Thing', $item->item->name);
    }

    public function testFindByIdsWithMultipleIds(): void
    {
        $expectedPropertyID1 = 'SXRlbTo3MTA1';
        $expectedPropertyID2 = 'SXRlbTo3MTA5';
        $propertiesIds = array_splice(PropertiesHelper::makeIdsArray(), 0, 2);
        $this->assertCount(2, $propertiesIds);
        $this->assertSame($expectedPropertyID2, $propertiesIds[0]);
        $this->assertSame($expectedPropertyID1, $propertiesIds[1]);
        $LodgingProductRepository = $this->makeLodgingProductRepository();
        $result = $LodgingProductRepository->findByIds($propertiesIds);
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $item1 = $result[0];
        $item2 = $result[1];
        PropertiesHelper::assertPropertyItem($this, $item1);
        PropertiesHelper::assertPropertyItem($this, $item2);
        $this->assertSame($expectedPropertyID1, $item1->item->id);
        $this->assertSame('069 Sawyer Two', $item1->item->name);
        $this->assertSame($expectedPropertyID2, $item2->item->id);
        $this->assertSame('102 A Shore Thing', $item2->item->name);
    }

    public function testFindByIdsWithInvalidId(): void
    {
        $LodgingProductRepository = $this->makeLodgingProductRepository();
        $result = $LodgingProductRepository->findByIds(['invalidPropertyId']);
        $this->assertNull($result);
    }

    public function testFindByIdsWithValidAndInvalidIds(): void
    {
        $LodgingProductRepository = $this->makeLodgingProductRepository();
        $propertyId = PropertiesHelper::properties()[0][PropertiesHelper::propretyIdKey()];
        $this->assertSame('SXRlbTo3MTA5', $propertyId);
        $result = $LodgingProductRepository->findByIds(['invalidPropertyId', $propertyId]);
        $this->assertNull($result);
    }
}
