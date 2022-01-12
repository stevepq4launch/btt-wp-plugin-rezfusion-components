<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Shortcodes\LodgingItemAvailPicker;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingItemAvailPickerTest extends BaseTestCase
{
    public function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new LodgingItemAvailPicker(new Template(Templates::itemAvailPickerTemplate()));
        return $Shortcode->render($attributes);
    }

    public function testRender(): void
    {
        $propertyId = PropertiesHelper::getRandomPropertyId();
        $existingAttributes = [];
        $attributesToCheck = [
            'data-rezfusion-restrictions',
            'data-rezfusion-availability',
            'data-rezfusion-prices',
            'data-rezfusion-item-id',
            'data-rezfusion-item-pms-id',
            'data-rezfusion-item-type',
            'data-rezfusion-channel',
            'data-rezfusion-endpoint',
            'data-rezfusion-sps-domain',
            'data-rezfusion-conf-page'
        ];

        $html = $this->renderShortcode([
            'channel' => get_rezfusion_option(Options::hubChannelURL()),
            'itemid' => $propertyId
        ]);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        TestHelper::assertElementWithClassExists(
            $this,
            $DOMXPath,
            'lodging-item-details__avail-picker'
        );
        $element = TestHelper::queryDOMXPath($DOMXPath, 'lodging-item-details__avail-picker');
        $item = $element->item(0);
        foreach ($item->attributes as $attribute) {
            $existingAttributes[] = $attribute->name;
        }
        foreach ($attributesToCheck as $attribute) {
            $this->assertTrue(in_array($attribute, $existingAttributes), sprintf("Attribute %s is missing.", $attribute));
        }
        $this->assertSame($propertyId, $item->getAttribute('data-rezfusion-item-id'));
    }

    public function testRenderFail(): void
    {
        $html = $this->renderShortcode([
            'channel' => '',
            'itemid' => ''
        ]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }
}
