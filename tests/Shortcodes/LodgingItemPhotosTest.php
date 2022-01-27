<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\LodgingItemPhotos;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;

class LodgingItemPhotosTest extends BaseTestCase
{
    public function testRenderWithInvalidAttributes(): void
    {
        $Shortcode = new LodgingItemPhotos(new Template(Templates::itemPhotosTemplate()));
        $html = $Shortcode->render([]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }
}
