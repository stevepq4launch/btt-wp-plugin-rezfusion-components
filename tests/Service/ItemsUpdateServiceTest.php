<?php

namespace Rezfusion\Tests\Service;

use Rezfusion\Client\Client;
use Rezfusion\Metas;
use Rezfusion\PostTypes;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\DataRefreshService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class ItemsUpdateService extends BaseTestCase
{
    private function makeDataRefreshService(array $items = []): DataRefreshService
    {
        $NoItemsClient = $this->createMock(Client::class);
        $NoItemsClient->method('getItems')->willReturn(json_decode(json_encode(
            ['data' => ['lodgingProducts' => ['results' => $items]]]
        )));
        $NoItemsClient->method('getCategories')->willReturn(
            json_decode(json_encode(['data' => ['categoryInfo' => ['categories' => []]]]))
        );
        $DataRefreshService = new DataRefreshService($NoItemsClient, false);
        $DataRefreshService->run();
        return $DataRefreshService;
    }

    private function getItemsCountByPropertyId(string $propertyId = ''): int
    {
        global $wpdb;
        return intval($wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(p.id) FROM $wpdb->posts p LEFT JOIN $wpdb->postmeta pm ON pm.post_id = p.id AND pm.meta_key = %s WHERE pm.meta_value = %s", [
                Metas::itemId(),
                $propertyId
            ])
        ));
    }

    private function getItemsCount(): int
    {
        global $wpdb;
        return intval($wpdb->get_var(
            $wpdb->prepare("SELECT COUNT(p.id) FROM $wpdb->posts p LEFT JOIN $wpdb->postmeta pm ON pm.post_id = p.id AND pm.meta_key = %s", [Metas::itemId()])
        ));
    }

    public function testItemsUpdateWithReappearingProperty(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $initialItemsCount = $this->getItemsCount();
        $this->assertGreaterThan(PropertiesHelper::minPropertiesCountInHub(), $initialItemsCount);

        // First run.
        $propertyID = PropertiesHelper::getRandomPropertyId();
        $this->assertSame(1, $this->getItemsCountByPropertyId($propertyID));

        // Second run, clear all items.
        $DataRefreshService = $this->makeDataRefreshService([[
            'item' => [
                'id' => -1
            ]
        ]]);
        $DataRefreshService->run();
        $initialItemsCount++;
        $this->assertSame(1, $this->getItemsCountByPropertyId($propertyID));
        $this->assertSame($initialItemsCount, $this->getItemsCount());

        // Third run, properties reappears.
        $DataRefreshService = new DataRefreshService(TestHelper::makeAPI_TestClient(), false);
        $DataRefreshService->run();
        $this->assertSame(1, $this->getItemsCountByPropertyId($propertyID));
        $this->assertSame($initialItemsCount, $this->getItemsCount());
    }

    /**
     * Tests if correct post gets activated when there's a few posts for the same property.
     * @return void
     */
    public function testRunWithMultipleExistingProperties(): void
    {
        $this->refreshDatabaseDataAfterTest();
        $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        $propertyID = 'abcdef1';
        $items = [['item' => [
            'name' => 'Test Property',
            'id' => $propertyID
        ]]];
        $postsIds = [];
        $validID = null;

        for ($i = 1; $i <= 5; $i++) {
            $data = [
                'post_type' => PostTypes::listing(),
                'post_status' => 'draft',
                'post_title' => "Test Property",
                'meta_input' => [
                    Metas::itemId() => $propertyID,
                    Metas::beds() => 2,
                    Metas::baths() => 3
                ]
            ];
            $postsIds[] = wp_insert_post($data);
        }

        $validID = $postsIds[0];

        $this->assertNotEmpty($validID);
        $this->assertIsInt($validID);
        $this->assertGreaterThan(0, $validID);

        $this->assertSame('', $ItemRepository->getPropertyKeyByPostId($validID));

        foreach ($postsIds as $postId) {
            $this->assertSame('draft', get_post_status($postId));
        }

        wp_publish_post($validID);
        $this->assertSame('publish', get_post_status($validID));
        wp_publish_post($postsIds[1]);
        $this->assertSame('publish', get_post_status($postsIds[1]));
        wp_trash_post($validID);
        $this->assertSame('trash', get_post_status($validID));
        wp_publish_post($postsIds[4]);
        $this->assertSame('publish', get_post_status($postsIds[4]));

        $DataRefreshService = $this->makeDataRefreshService($items);
        $DataRefreshService->run();

        $this->assertSame($propertyID, $ItemRepository->getPropertyKeyByPostId($validID));
        $property = $ItemRepository->getItemById($propertyID);
        $this->assertIsArray($property);
        $this->assertSame($validID, intval($property[0]['ID']));

        foreach ($postsIds as $postId) {
            $this->assertSame($postId === $validID ? 'publish' : 'draft', get_post_status($postId));
        }
    }

    public function assertPropertyPostData(array $post = null, array $data = [])
    {
        $this->assertIsArray($post);
        $this->assertNotEmpty($post[0]['post_id']);
        $postID = $post[0]['post_id'];
        $post = get_post($postID);
        $this->assertSame('publish', $post->post_status);
        $this->assertSame($data['item']['name'], $post->post_title);
        $meta = get_post_meta($postID);
        $this->assertSame($data['item']['id'], $meta['rezfusion_hub_item_id'][0]);
        $this->assertIsNumeric($meta['rezfusion_hub_beds'][0]);
        $this->assertIsNumeric($meta['rezfusion_hub_baths'][0]);
        $this->assertSame($data['beds'], intval($meta['rezfusion_hub_beds'][0]));
        $this->assertSame($data['baths'], intval($meta['rezfusion_hub_baths'][0]));
    }

    public function testDataIsValid(): void
    {
        $this->refreshDatabaseDataAfterTest();
        TestHelper::deleteData();
        $itemData = [
            'item' => [
                'id' => 'test1001',
                'name' => 'Test Property #1'
            ],
            'beds' => 5,
            'baths' => 6
        ];
        $DataRefreshService = $this->makeDataRefreshService([$itemData]);
        $DataRefreshService->run();

        $ItemRepository = (new ItemRepository(TestHelper::makeAPI_TestClient()));
        $post = $ItemRepository->getItemById('test1001');
        $this->assertPropertyPostData($post, $itemData);
        $firstPostID = $post[0]['post_id'];

        $itemData['item']['name'] = 'Test#2';
        $DataRefreshService = $this->makeDataRefreshService([$itemData]);
        $DataRefreshService->run();
        $post = $ItemRepository->getItemById('test1001');
        $this->assertPropertyPostData($post, $itemData);
        $this->assertSame($firstPostID, $post[0]['post_id']);
    }
}
