<?php

namespace Rezfusion\Tests\Helper;

use Rezfusion\Helper\StarsRatingRenderer;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class StarsRatingRendererTest extends BaseTestCase
{
    public function testRender()
    {
        $divOpen = '<div class="rezfusion-stars-rating">';
        $activeStar = '<span class="rezfusion-stars-rating__star rezfusion-stars-rating__star--active">&#9733;</span>';
        $inactiveStar = '<span class="rezfusion-stars-rating__star rezfusion-stars-rating__star--inactive">&#9734;</span>';
        $divClose = '</div>';
        $maxRating = 10;
        $StarsRatingRenderer = new StarsRatingRenderer($maxRating);

        for ($rating = 1; $rating <= $maxRating; $rating++) {
            $expect = '';
            $expect .= $divOpen;
            for ($star = 1; $star <= $maxRating; $star++) {
                $expect .= ($star <= $rating) ? $activeStar : $inactiveStar;
            }
            $expect .= $divClose;
            $actual = $StarsRatingRenderer->render($rating);
            $this->assertSame($expect, $actual, sprintf("Rating: %d", $rating));
        }
    }

    public function testBaseClassName()
    {
        $this->assertSame('rezfusion-stars-rating', StarsRatingRenderer::BASE_CLASS_NAME);
    }

    public function testStarClassName()
    {
        $this->assertSame('rezfusion-stars-rating__star', StarsRatingRenderer::STAR_CLASS_NAME);
    }

    public function testActiveStarClassName()
    {
        $this->assertSame('rezfusion-stars-rating__star--active', StarsRatingRenderer::ACTIVE_STAR_CLASS_NAME);
    }

    public function testInactiveStarClassName()
    {
        $this->assertSame('rezfusion-stars-rating__star--inactive', StarsRatingRenderer::INACTIVE_STAR_CLASS_NAME);
    }

    public function testActiveStarSymbol()
    {
        $this->assertSame('&#9733;', StarsRatingRenderer::ACTIVE_STAR_SYMBOL);
    }

    public function testInactiveStarSymbol()
    {
        $this->assertSame('&#9734;', StarsRatingRenderer::INACTIVE_STAR_SYMBOL);
    }
}
