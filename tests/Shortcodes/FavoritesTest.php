<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\Favorites;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;

class FavoritesTest extends BaseTestCase
{
    public function testRender(): void
    {
        $Shortcode = new Favorites(new Template(Templates::favoritesTemplate()));
        $html = $Shortcode->render([]);
        $this->assertSame('<div id="favorites-page"></div>', $html);
    }
}
