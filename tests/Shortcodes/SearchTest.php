<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\Search;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class SearchTest extends BaseTestCase
{
    public function testRender(): void
    {
        $Shortcode = new Search(new Template(Templates::searchTemplate()));
        $html = $Shortcode->render([]);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        $this->assertGreaterThan(0, $DOMXPath->query('//div[@id="app"]')->length);
        TestHelper::assertStrings($this, $html, [
            'promoCodePropertiesIds',
            'promoCodeText',
            'propertyCardFlag'
        ]);
    }
}
