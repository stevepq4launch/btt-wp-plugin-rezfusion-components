<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\LodgingItemReviews;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingItemReviewsTest extends BaseTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $Shortcode = new LodgingItemReviews(new Template(Templates::itemReviewsTemplate()));
        $html = $Shortcode->render([
            'itemid' => PropertiesHelper::getRandomPropertyId()
        ]);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        TestHelper::assertClassesCount($this, $DOMXPath, 'lodging-item-reviews-list', 1);
        TestHelper::assertClassesCount($this, $DOMXPath, 'lodging-item-review', 5);
        foreach ([
            'lodging-item-review__heading',
            'lodging-item-review__rating',
            'lodging-item-review__stay-dates',
            'lodging-item-review__guest-name',
            'lodging-item-review__comment'
        ] as $className) {
            TestHelper::assertElementWithClassExists($this, $DOMXPath, $className);
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithInvalidArguments(): void
    {
        $Shortcode = new LodgingItemReviews(new Template(Templates::itemReviewsTemplate()));
        $html = $Shortcode->render([]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }
}
