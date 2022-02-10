<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Helper\FloorPlanHelper;
use Rezfusion\Repository\FloorPlanRepository;
use Rezfusion\Shortcodes\FloorPlan;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class FloorPlanTest extends BaseTestCase
{
    private function assertHTML(string $html = '', string $provider = '', string $url = ''): void
    {
        TestHelper::assertStrings($this, $html, [
            '<section id="rezfusion-floor-plan" class="rezfusion-floor-plan">',
            '<div class="rezfusion-property__section-title-wrap rezfusion-floor-plan__section-title-wrap">',
            '<h2 class="rezfusion-property__section-title rezfusion-floor-plan__section-title">Floor Plan</h2>',
            '<div class="rezfusion-floor-plan__display rezfusion-floor-plan__display--' . $provider . '">',
            ($provider === FloorPlanHelper::truplaceProvider())
                ? '<button class="btn rezfusion-floor-plan__btn" onclick="TourWidget(\'' . $url . '\');">View Floor Plan</button>'
                : '<iframe src="' . $url . '" class="rezfusion-floor-plan__iframe"></iframe>'
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithTruPlace(): void
    {
        $postID = PostHelper::getRecentPostId();
        $url = "https://tour.truplace.com/property/1/1";
        $Shortcode = new FloorPlan(new Template(Templates::floorPlanTemplate()));
        $FloorPlanRepository = new FloorPlanRepository(TestHelper::makeAPI_TestClient(), '');

        $FloorPlanRepository->save($postID, $url);
        $html = $Shortcode->render([
            'postid' => $postID
        ]);

        $this->assertHTML($html, FloorPlanHelper::truplaceProvider(), 'https://tour.truplace.com//property/1/1');
    }

    public function testRenderWithMatteport(): void
    {
        $postID = PostHelper::getRecentPostId();
        $url = "https://matterport.com/";
        $Shortcode = new FloorPlan(new Template(Templates::floorPlanTemplate()));
        $FloorPlanRepository = new FloorPlanRepository(TestHelper::makeAPI_TestClient(), '');

        $FloorPlanRepository->save($postID, $url);
        $html = $Shortcode->render([
            'postid' => $postID
        ]);

        $this->assertHTML($html, FloorPlanHelper::matterportProvider(), $url);
    }
}
