<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\PostRecentVisits;
use Rezfusion\Shortcodes\UrgencyAlert;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class UrgencyAlertTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        OptionManager::update(Options::urgencyAlertEnabled(), true);
        OptionManager::update(Options::urgencyAlertMinimumVisitors(), 3);
        OptionManager::update(Options::urgencyAlertDaysThreshold(), 3);
    }

    public function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new UrgencyAlert(new Template(Templates::urgencyAlertTemplate()));
        return $Shortcode->render($attributes);
    }

    public function testVisitorsCountTag(): void
    {
        $this->assertSame('[[visitorsCount]]', UrgencyAlert::VISITORS_COUNT_TAG);
    }

    public function testDefaultHighlightedText(): void
    {
        $this->assertSame('Popular', UrgencyAlert::DEFAULT_HIGHLIGHTED_TEXT);
    }

    public function testDefaultUrgencyText(): void
    {
        $this->assertSame("Recently viewed by " . UrgencyAlert::VISITORS_COUNT_TAG . " other travelers!", UrgencyAlert::defaultUrgencyText());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithFeatureDisabled(): void
    {
        OptionManager::update(Options::urgencyAlertEnabled(), false);
        $html = $this->renderShortcode([]);
        $this->assertSame('', $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithoutPostId(): void
    {
        OptionManager::update(Options::urgencyAlertEnabled(), true);
        $html = $this->renderShortcode([]);
        $this->assertSame('Rezfusion Urgency Alert: Post ID is required', $html);
    }

    public function testRenderWithoutValidMinimumVisitors(): void
    {
        $postID = PostHelper::getRecentPostId();
        OptionManager::update(Options::urgencyAlertMinimumVisitors(), -1);
        $html = $this->renderShortcode([
            'postid' => $postID
        ]);
        $this->assertSame('Rezfusion Urgency Alert: Minimum visitors value must be greater than 0.', $html);
    }

    private function assertRecentVisitsCount($postID = 0, $expected = 0): void
    {
        $postRecentVisitsCount = get_post_meta($postID, PostRecentVisits::RECENT_VISITS_COUNT_META_KEY, true);
        $this->assertEquals($expected, $postRecentVisitsCount);
    }

    private function saveRecentVisitsData($postID = 0, $count = 10): void
    {
        delete_post_meta($postID, PostRecentVisits::RECENT_VISITS_COUNT_META_KEY);
        delete_post_meta($postID, PostRecentVisits::META_KEY);
        $recentVisitsData = [];
        for ($i = 0; $i < $count; $i++) {
            $recentVisitsData['session-id-' . $i] = date('Y-m-d H:i:s', time());
        }
        update_post_meta($postID, PostRecentVisits::META_KEY, $recentVisitsData);
        add_post_meta($postID, PostRecentVisits::RECENT_VISITS_COUNT_META_KEY, $count);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $postID = PostHelper::getRecentPostId();
        $recentVisitsCount = 10;
        $this->saveRecentVisitsData($postID, $recentVisitsCount);
        $this->assertRecentVisitsCount($postID, $recentVisitsCount);
        $html = $this->renderShortcode([
            'postid' => $postID
        ]);
        $this->assertStringContainsString('<div class="rezfusion-urgency-alert">', $html);
        TestHelper::assertRegExps($this, $html, [
            '/\<span class="rezfusion-urgency-alert__recently-viewed">Recently viewed by .* other travelers!\<\/span\>/i'
        ]);
        $this->assertRecentVisitsCount($postID, $recentVisitsCount + 1);
    }
}
