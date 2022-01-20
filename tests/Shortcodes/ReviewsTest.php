<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Repository\ReviewRepository;
use Rezfusion\Shortcodes\Reviews;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\ReviewHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class ReviewsTest extends BaseTestCase
{
    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
    }

    private function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new Reviews(new Template(Templates::reviewsTemplate()));
        return $Shortcode->render($attributes);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $ReviewRepository = new ReviewRepository();
        $postID = PostHelper::getRecentPostId();
        $reviewsCount = 10;
        $reviews = ReviewHelper::makeMockReviewsForPost($postID, $reviewsCount);
        foreach ($reviews as $Review) {
            $Review->setApproved(true);
        }
        ReviewHelper::saveReviews($reviews);
        $this->assertCount($reviewsCount, $ReviewRepository->getReviews($postID));
        $html = $this->renderShortcode([
            'postid' => $postID
        ]);
        $this->assertNotEmpty($html);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        $classesToCheck = [
            'rezfusion-reviews',
            'rezfusion-reviews__section-title-wrap',
            'rezfusion-reviews__section-title',
            'rezfusion-reviews__list',
            'rezfusion-review__border',
            'rezfusion-review__title',
            'rezfusion-review__rating',
            'rezfusion-stars-rating',
            'rezfusion-review__comment',
            'rezfusion-review__info',
            'rezfusion-review__guest-name',
            'rezfusion-review__stay-dates'
        ];
        foreach ($classesToCheck as $class) {
            TestHelper::assertElementContainingClassExists($this, $DOMXPath, $class);
        }
        TestHelper::assertClassesCount($this, $DOMXPath, 'rezfusion-review', $reviewsCount);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithoutPostId(): void
    {
        $this->assertSame('Post ID is required to show reviews.', $this->renderShortcode([]));
    }
}
