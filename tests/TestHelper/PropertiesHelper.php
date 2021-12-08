<?php

namespace Rezfusion\Tests\TestHelper;

use PHPUnit\Framework\TestCase;
use RuntimeException;

class PropertiesHelper
{
    const MIN_PROPERTIES_COUNT_IN_HUB = 20;

    const PROPERTY_ID_KEY = 'id';

    const PROPERTIES = [
        [
            'id' => 'SXRlbTo3MTA5'
        ],
        [
            'id' => 'SXRlbTo3MTA1'
        ],
        [
            'id' => 'SXRlbTo3MTA2'
        ],
        [
            'id' => 'SXRlbTo3MTA3'
        ],
        [
            'id' => 'SXRlbTo3MTA4'
        ]
    ];

    public static function properties(): array
    {
        return static::PROPERTIES;
    }

    public static function propretyIdKey(): string
    {
        return static::PROPERTY_ID_KEY;
    }

    public static function makeIdsArray(): array
    {
        return array_map(function ($property) {
            return $property[static::PROPERTY_ID_KEY];
        }, static::properties());
    }

    public static function getRandomPropertyId(): string
    {
        $properties = static::makeIdsArray();
        $id = $properties[0];
        if (empty($id)) {
            throw new RuntimeException("Invalid property id.");
        }
        return $id;
    }

    public static function minPropertiesCountInHub(): int
    {
        return static::MIN_PROPERTIES_COUNT_IN_HUB;
    }

    public static function assertPropertyItem(TestCase $Test, object $item): void
    {
        $Test->assertIsObject($item);
        $Test->assertObjectHasAttribute('beds', $item);
        $Test->assertObjectHasAttribute('baths', $item);
        $Test->assertObjectHasAttribute('occ_total', $item);
        $Test->assertObjectHasAttribute('item', $item);
        $Test->assertObjectHasAttribute('id', $item->item);
        $Test->assertObjectHasAttribute('name', $item->item);
        $Test->assertObjectHasAttribute('images', $item->item);
        $Test->assertIsArray($item->item->images);
        if (count($item->item->images)) {
            $image = $item->item->images[0];
            $Test->assertObjectHasAttribute('url', $image);
            $Test->assertObjectHasAttribute('derivatives', $image);
            $Test->assertObjectHasAttribute('description', $image);
            $Test->assertObjectHasAttribute('title', $image);
            if (count($image->derivatives)) {
                $imageDerivative = $image->derivatives[0];
                $Test->assertObjectHasAttribute('url', $imageDerivative);
                $Test->assertObjectHasAttribute('dimensions', $imageDerivative);
            }
        }
    }
}
