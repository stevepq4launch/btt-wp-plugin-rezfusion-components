<?php

namespace Rezfusion\Tests\Repository;

use Rezfusion\Metas;
use Rezfusion\Options;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\ClientHelper;
use Rezfusion\Tests\TestHelper\Factory;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\PropertiesHelper;

class ItemRepositoryTest extends BaseTestCase
{
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
}
