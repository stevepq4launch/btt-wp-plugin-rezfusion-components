<?php

namespace Rezfusion\Tests\Repository;

use Rezfusion\Entity\HubDataPropertyAdapter;
use Rezfusion\Entity\PostPropertyAdapter;
use Rezfusion\Entity\Property;
use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\PostStatus;
use Rezfusion\PostTypes;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\ClientHelper;
use Rezfusion\Tests\TestHelper\Factory;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;
use RuntimeException;
use stdClass;

class ItemRepositoryTest extends BaseTestCase
{
    private function doSaveItemTest($Item, $postStatus, $findByPostId): void
    {
        $Item->setId('test1001');
        $Item->setPostStatus($postStatus);
        $Item->setName('Test Property #1');
        $Item->setBaths(3);
        $Item->setBeds(4);

        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $ItemRepository->saveItem($Item);
        $this->assertIsInt($Item->getPostId());
        $this->assertNotEmpty($Item->getPostId());
        $this->assertGreaterThan(0, $Item->getPostId());
        $this->assertSame(PostTypes::listing(), $Item->getPostType());

        $FoundItem = ($findByPostId === true)
            ? $ItemRepository->findItemByPostId($Item->getPostId())
            : $ItemRepository->findItem('test1001');

        $this->assertSame($postStatus, $FoundItem->getPostStatus());
        $this->assertSame($Item->getPostId(), $FoundItem->getPostId());
        $this->assertSame('vr_listing', $FoundItem->getPostType());
        $this->assertSame(3, $FoundItem->getBaths());
        $this->assertSame(4, $FoundItem->getBeds());
        $this->assertSame('Test Property #1', $FoundItem->getName());
        $this->assertSame('test1001', $FoundItem->getId());
    }

    public function testPostType(): void
    {
        $this->assertSame(PostTypes::listing(), ItemRepository::postType());
        $this->assertSame(get_rezfusion_option(Options::syncItemsPostType(), PostTypes::listing()), ItemRepository::postType());
    }

    public function testSaveItemWithDifferentEntities(): void
    {
        $this->refreshDatabaseDataAfterTest();
        TestHelper::deleteData();
        $this->doSaveItemTest(new Property, 'publish', false);
        TestHelper::deleteData();
        $this->doSaveItemTest(new HubDataPropertyAdapter((object) ['item' => (object)[]]), 'publish', false);
        TestHelper::deleteData();
        $this->doSaveItemTest(new PostPropertyAdapter(new stdClass, []), 'publish', false);
        TestHelper::deleteData();
        $this->doSaveItemTest(new Property, 'trash', true);
        TestHelper::deleteData();
        $this->doSaveItemTest(new HubDataPropertyAdapter((object) ['item' => (object)[]]), 'trash', true);
        TestHelper::deleteData();
        $this->doSaveItemTest(new PostPropertyAdapter(new stdClass, []), 'trash', true);
    }

    public function testSaveItemWithInvalidData(): void
    {
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('Post was not saved.');
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $Item = new Property;
        $Item->setPostId(-1);
        $ItemRepository->saveItem($Item);
    }

    public function testRedundantItemsRemoval(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $API_Client = ClientHelper::getInstance()->makeClientReturningItems([
            'data' => [
                'lodgingProducts' => [
                    'results' => [
                        [
                            'item' => [
                                'id' => 1000
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $currentPostsCount = PostHelper::publishedPropertiesPostsCount();
        $this->assertGreaterThan(PropertiesHelper::minPropertiesCountInHub(), $currentPostsCount);
        $ItemRepository = new ItemRepository($API_Client);
        $ItemRepository->updateItems(
            OptionsHandlerProvider::getInstance()->getOption(Options::hubChannelURL())
        );
        $currentPostsCount = PostHelper::publishedPropertiesPostsCount();
        $this->assertSame(1, $currentPostsCount);
    }

    public function testGetItemById(): void
    {
        $itemId = PropertiesHelper::getRandomPropertyId();
        $this->assertNotEmpty($itemId);
        $API_Client = Factory::makeAPI_ClientMock();
        $ItemRepository = new ItemRepository($API_Client);
        $items = $ItemRepository->getItemById($itemId);
        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $this->assertSame($items[0]['meta_value'], $itemId);
    }

    public function testGetPropertyKeyByPostId(): void
    {
        $postId = PostHelper::getRecentPostId();
        $this->assertNotEmpty($postId);
        $ItemRepository = new ItemRepository(Factory::makeAPI_ClientMock());
        $expectedPropertyId = get_post_meta($postId, Metas::itemId(), true);
        $this->assertNotEmpty($expectedPropertyId);
        $propertyId = $ItemRepository->getPropertyKeyByPostId($postId);
        $this->assertNotEmpty($propertyId);
        $this->assertSame($expectedPropertyId, $propertyId);
    }

    public function testGetPromoCodePropertiesIds(): void
    {
        $ItemRepository = new ItemRepository(Factory::makeAPI_TestClient());
        $propertiesIds = PropertiesHelper::makeIdsArray();
        $this->assertCount(5, $propertiesIds);

        $postIdFieldName = 'post_id';
        $propertiesPostsIds1 = [
            $ItemRepository->getItemById($propertiesIds[0])[0][$postIdFieldName],
            $ItemRepository->getItemById($propertiesIds[1])[0][$postIdFieldName],
        ];
        $propertiesPostsIds2 = [
            $ItemRepository->getItemById($propertiesIds[2])[0][$postIdFieldName]
        ];

        foreach (array_merge(
            $propertiesPostsIds1,
            $propertiesPostsIds2
        ) as $id) {
            $this->assertNotEmpty($id);
            $this->assertIsString($id);
        }

        PostHelper::insertPromoPost('test-promo-code-1', $propertiesPostsIds1);
        PostHelper::insertPromoPost('test-promo-code-2', $propertiesPostsIds2);

        $promoCodePropertiesIds = $ItemRepository->getPromoCodePropertiesIds();
        $this->assertCount(3, $promoCodePropertiesIds);

        foreach ($promoCodePropertiesIds as $id) {
            $this->assertTrue(in_array($id, $propertiesIds));
            $this->assertContains($id, $propertiesIds);
        }
    }

    public function testFindItems(): void
    {
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $itemsIds = $ItemRepository->getAllItemsIds();
        $this->assertGreaterThan(PropertiesHelper::minPropertiesCountInHub(), $itemsIds);
        $items = $ItemRepository->findItems();
        $this->assertCount(count($itemsIds), $items);
    }

    public function testFindItemsWithStatus(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $itemsIds = array_slice($ItemRepository->getAllItemsIds(), 0, 5);
        $this->assertCount(5, $itemsIds);
        foreach ($itemsIds as $index => $id) {
            $Item = $ItemRepository->findItem($id);
            $Item->setPostStatus($index < 3 ? PostStatus::trashStatus() : PostStatus::draftStatus());
            $ItemRepository->saveItem($Item);
        }
        $this->assertCount(3, $ItemRepository->findItems([PostStatus::trashStatus()]));
        $this->assertCount(2, $ItemRepository->findItems([PostStatus::draftStatus()]));
    }

    public function testSavePropertyDuplicate(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Property item exists in database.');
        $this->refreshDatabaseDataAfterTest();
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $id = PropertiesHelper::getRandomPropertyId();
        $Item = $ItemRepository->findItem($id);
        $Item->setPostStatus(PostStatus::trashStatus());
        $ItemRepository->saveItem($Item);
        $NewItem = new Property();
        $NewItem->setId($id);
        $ItemRepository->saveItem($NewItem);
    }

    public function testFindItemsWithPropertiesIds(): void
    {
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $itemsIds = array_slice($ItemRepository->getAllItemsIds(), 0, 3);
        $items = $ItemRepository->findItems([], $itemsIds);
        $this->assertCount(3, $items);
        foreach ($items as $index => $Item) {
            $this->assertTrue(in_array($Item->getId(), $itemsIds));
        }
    }
}
