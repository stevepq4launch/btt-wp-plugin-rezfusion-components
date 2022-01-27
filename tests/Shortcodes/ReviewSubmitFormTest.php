<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Shortcodes\ReviewSubmitForm;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class ReviewSubmitFormTest extends BaseTestCase
{
    private function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new ReviewSubmitForm(new Template(Templates::reviewSubmitFormTemplate()));
        $html = $Shortcode->render($attributes);
        $this->assertNotEmpty($html);
        return $html;
    }

    public function testRender(): void
    {
        $postID = PostHelper::getRecentPostId();
        $html = $this->renderShortcode(['postid' => $postID]);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        $this->assertSame(1, $DOMXPath->query('//form')->length);
        $this->assertSame(4, $DOMXPath->query('//input')->length);
        $this->assertSame(1, $DOMXPath->query('//textarea')->length);
        foreach ([
            'rezfusion-review-submit',
            'rezfusion-review-form__field-wrap',
            'rezfusion-review-form__field',
            'rezfusion-review-submit__add-review-button',
            'rezfusion-review-form__field--name',
            'rezfusion-review-form__label--rating',
            'rezfusion-review-form__label--date',
            'rezfusion-review-form__label--title',
            'rezfusion-review-form__label--content',
            'rezfusion-review-form__field--submit',
        ] as $class) {
            TestHelper::assertElementContainingClassExists($this, $DOMXPath, $class);
        }
        $this->assertGreaterThan(0, $DOMXPath->query('//*[@id="rezfusion-review-submit__form__message-container"]')->length);
        foreach ([
            'review-guest-name',
            'review-rating',
            'review-stay-date',
            'review-title',
            'review-content'
        ] as $inputName) {
            $this->assertGreaterThan(0, $DOMXPath->query('//*[@name="' . $inputName . '"]')->length);
        }
    }

    public function testRenderWithoutPostId(): void
    {
        $html = $this->renderShortcode([]);
        $this->assertSame('Post ID is required to show reviews.', $html);
    }
}
