<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\LodgingItemFavoriteToggle;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingItemFavoriteToggleTest extends BaseTestCase
{
    private function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new LodgingItemFavoriteToggle(new Template(Templates::favoriteToggleTemplate()));
        return $Shortcode->render($attributes);
    }

    public function testRender(): void
    {
        $html = $this->renderShortcode([
            'itemid' => PropertiesHelper::getRandomPropertyId()
        ]);
        TestHelper::assertRegExps($this, $html, [
            '/\<div class="favorite-toggle" data-rezfusion-item-id=".*" data-rezfusion-item-name=".*" data-rezfusion-toggle-type="&quot;small&quot;"\>\<\/div\>/i'
        ]);
    }

    public function testRenderWithInvalidArguments(): void
    {
        $html = $this->renderShortcode([]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }
}
