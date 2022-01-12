<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\LodgingItemAvailCalendar;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingItemAvailCalendarTest extends BaseTestCase
{
    private function makeShortcode(): LodgingItemAvailCalendar
    {
        return new LodgingItemAvailCalendar(new Template(Templates::itemAvailCalendarTemplate()));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $Shortcode = $this->makeShortcode();
        $html = $Shortcode->render([
            'itemid' => PropertiesHelper::getRandomPropertyId()
        ]);
        $xpath = TestHelper::makeDOMXPath($html);
        TestHelper::assertElementWithClassExists($this, $xpath, 'lodging-item-details__avail-calendar');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithInvalidAttributes(): void
    {
        $Shortcode = $this->makeShortcode();
        $html = $Shortcode->render([]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }
}
