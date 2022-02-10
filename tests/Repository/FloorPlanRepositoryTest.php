<?php

namespace Rezfusion\Tests\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use Rezfusion\Client\Client;
use Rezfusion\Client\ClientInterface;
use Rezfusion\Metas;
use Rezfusion\Repository\FloorPlanRepository;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class FloorPlanRepositoryTest extends BaseTestCase
{
    /**
     * @var string
     */
    const TEST_FLOOR_PLAN_URL = 'https://www.floor-plan.com/';

    /**
     * @var FloorPlanRepository
     */
    private $FloorPlanRepository;

    private function clearFloorPlanData(): void
    {
        delete_post_meta(PostHelper::getRecentPostId(), Metas::postFloorPlanURL());
    }

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->clearFloorPlanData();
        $this->FloorPlanRepository = $this->makeFloorPlanRepository();
    }

    /**
     * @param null|ClientInterface $API_Client
     * 
     * @return FloorPlanRepository
     */
    private function makeFloorPlanRepository($API_Client = null): FloorPlanRepository
    {
        return new FloorPlanRepository(
            !empty($API_Client) ? $API_Client : TestHelper::makeAPI_TestClient(),
            ''
        );
    }

    /**
     * Creates mock of API Client that will return item with specified data.
     * @param string $itemData
     * 
     * @return MockObject
     */
    private function makeClientMock(string $itemData = ''): MockObject
    {
        $Client = $this->createMock(Client::class);
        $Client->method('call')->willReturn(json_decode('{"data":{"lodgingProducts":{"results":[{"item":' . $itemData . '}]}}}'));
        return $Client;
    }

    public function testSaveWithInvalidPostId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid post ID.');
        $this->FloorPlanRepository->save(null);
    }

    public function testFindOneByPostID(): void
    {
        $postID = PostHelper::getRecentPostId();
        $floorPlanData = $this->FloorPlanRepository->findOneByPostID($postID);
        $this->assertIsArray($floorPlanData);
        $this->assertArrayHasKey('url', $floorPlanData);
        $this->assertEmpty($floorPlanData['url']);
    }

    public function testFindAll(): void
    {
        $data = $this->FloorPlanRepository->findAll();
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        TestHelper::log($data);
    }

    public function testSave(): void
    {
        $postID = PostHelper::getRecentPostId();
        $url = static::TEST_FLOOR_PLAN_URL;
        $this->assertTrue($this->FloorPlanRepository->save($postID, $url));
        $this->assertFalse($this->FloorPlanRepository->save($postID, $url));
        $this->assertSame($url, $this->FloorPlanRepository->findOneByPostID($postID)['url']);
        $this->assertTrue($this->FloorPlanRepository->save($postID, ''));
        $this->assertFalse($this->FloorPlanRepository->save($postID, ''));
        $this->assertEmpty($this->FloorPlanRepository->findOneByPostID($postID)['url']);
    }

    public function testHasFloorPlanWithPostId(): void
    {
        $postID = PostHelper::getRecentPostId();
        $url = static::TEST_FLOOR_PLAN_URL;
        $this->assertTrue($this->FloorPlanRepository->save($postID, $url));
        $this->assertTrue($this->FloorPlanRepository->hasFloorPlan('', $postID));
        $this->assertTrue($this->FloorPlanRepository->save($postID, ''));
        $this->assertFalse($this->FloorPlanRepository->hasFloorPlan('', $postID));
    }

    public function testHasFloorPlanWithPropertyKey(): void
    {
        $FloorPlanRepository = $this->makeFloorPlanRepository(
            $this->makeClientMock('{"tour":{"url":"' . static::TEST_FLOOR_PLAN_URL . '"}}')
        );
        $this->assertTrue($FloorPlanRepository->hasFloorPlan('test'));
    }

    public function testFindURL_ForPropertyWithInvalidPropertKey(): void
    {
        $this->assertSame('', $this->FloorPlanRepository->findURL_ForProperty(false));
    }

    public function testFindURL_ForProperty(): void
    {
        $expectedUrl = static::TEST_FLOOR_PLAN_URL;
        $FloorPlanRepository = $this->makeFloorPlanRepository(
            $this->makeClientMock('{"tour":{"url":"' . $expectedUrl . '"}}')
        );
        $url = $FloorPlanRepository->findURL_ForProperty('test');
        $this->assertSame($expectedUrl, $url);
    }

    public function testFindURL_ForPropertyWithEmptyURL(): void
    {
        $FloorPlanRepository = $this->makeFloorPlanRepository($this->makeClientMock('{}'));
        $url = $FloorPlanRepository->findURL_ForProperty('test');
        $this->assertSame('', $url);
    }

    /**
     * @inheritdoc
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->clearFloorPlanData();
    }
}
