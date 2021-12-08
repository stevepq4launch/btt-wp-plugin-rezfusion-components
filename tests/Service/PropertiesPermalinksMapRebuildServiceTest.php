<?php

namespace Rezfusion\Tests\Service;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Service\PropertiesPermalinksMapRebuildService;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;
use RuntimeException;

class PropertiesPermalinksMapRebuildServiceTest extends BaseTestCase
{
    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
    }

    private function makeService($properties, $ItemRepository = null): PropertiesPermalinksMapRebuildService
    {
        if (empty($ItemRepository)) {
            $ItemRepository = new ItemRepository(TestHelper::makeAPI_TestClient());
        }
        return new PropertiesPermalinksMapRebuildService($properties, $ItemRepository);
    }

    private function makeProperties(array $data = [])
    {
        return json_decode(json_encode($data));
    }

    public function testRunWithMissingPropertyID(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid property ID.');
        $Service = $this->makeService($this->makeProperties([
            [
                'item' => [
                    'id' => null
                ]
            ]
        ]));
        $Service->run();
    }

    public function testRunWithInvalidPropertyID(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Post for property not found.');
        $Service = $this->makeService($this->makeProperties([
            [
                'item' => [
                    'id' => -1
                ]
            ]
        ]));
        $Service->run();
    }

    public function testRunWithInvalidPost(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid property post ID.');
        $ItemRepository = $this->createMock(ItemRepository::class);
        $ItemRepository->method('getItemById')->willReturn([[
            'invalid' => true
        ]]);
        $Service = $this->makeService($this->makeProperties([
            [
                'item' => [
                    'id' => -1
                ]
            ]
        ]), $ItemRepository);
        $Service->run();
    }

    public function testRunWithDuplicates(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Property URL duplicate.');
        $itemDuplicate = [
            'item' => [
                'id' => PropertiesHelper::getRandomPropertyId()
            ]
        ];
        $Service = $this->makeService($this->makeProperties([$itemDuplicate, $itemDuplicate]));
        $Service->run();
    }

    public function testRun(): void
    {
        $URL_MapOptionName = Options::URL_Map();
        delete_transient($URL_MapOptionName);
        $this->assertNull(OptionManager::get($URL_MapOptionName));
        $propertyID = PropertiesHelper::getRandomPropertyId();
        $Service = $this->makeService($this->makeProperties([
            [
                'item' => [
                    'id' => $propertyID
                ]
            ]
        ]));
        $Service->run();
        $URL_Map = get_transient($URL_MapOptionName);
        $this->assertNotEmpty($URL_Map);
        $this->assertIsArray($URL_Map);
        $this->assertCount(1, $URL_Map);
        $this->assertArrayHasKey($propertyID, $URL_Map);
        $this->assertSame('http://localhost:8080/?vr_listing=102-a-shore-thing', $URL_Map[$propertyID]);
        delete_transient($URL_MapOptionName);
    }
}
