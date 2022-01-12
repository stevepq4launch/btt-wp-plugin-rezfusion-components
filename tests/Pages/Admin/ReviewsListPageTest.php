<?php

namespace Rezfusion\Tests\Pages\Admin;

use Rezfusion\Pages\Admin\ReviewsListPage;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class ReviewsListPageTest extends BaseTestCase
{
    public function testPageName(): void
    {
        $this->assertSame('rezfusion_components_reviews_list', ReviewsListPage::pageName());
    }

    public function testDisplay(): void
    {
        $ReviewsListPage = new ReviewsListPage(new Template(Templates::reviewsListPage()));
        $ReviewsListPage->display();
        $this->setOutputCallback(function ($html) {
            TestHelper::assertStrings($this, $html, [
                '<div class="rezfusion-modal" id="rezfusion-reviews__review-preview">',
                '<div class="rezfusion-modal__wrap">',
                '<div id="rezfusion-reviews__review-preview__content"></div>',
                'ConfigurationReviewsListViewHandler('
            ]);
            TestHelper::assertRegExps($this, $html, [
                '/const wordpressNonce = ".*";/i'
            ]);
        });
    }
}
