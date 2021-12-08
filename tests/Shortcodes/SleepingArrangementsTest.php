<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\SleepingArrangements;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;

class SleepingArrangementsTest extends BaseTestCase
{
    public function testRender(): void
    {
        $Shortcode = new SleepingArrangements(new Template(Templates::sleepingArrangementsTemplate()));
        $html = $Shortcode->render([]);
        $this->assertSame("\n<div class=\"sleeping-arrangements\" data-rezfusion-rooms=\"null\"></div>\n", $html);
    }
}
