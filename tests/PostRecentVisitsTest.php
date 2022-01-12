<?php

/**
 * @file Tests for PostRecentVisitsTest.
 */

namespace Rezfusion\Tests;

use InvalidArgumentException;
use Rezfusion\Factory\PostRecentVisitsFactory;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\PostRecentVisits;
use Rezfusion\SessionHandler\SessionHandlerInterface;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class PostRecentVisitsTest extends BaseTestCase
{
    /**
     * @var PostRecentVisit
     */
    private $PostRecentVisits;

    /**
     * @var SessionHandlerInterface
     */
    private $SessionHandler;

    /**
     * @var int
     */
    private $postId;

    public static function doBefore(): void
    {
        parent::doBefore();
        TestHelper::refreshData();
    }

    public function setUp(): void
    {
        parent::setUp();
        OptionManager::update(Options::urgencyAlertEnabled(), true);
        OptionManager::update(Options::urgencyAlertMinimumVisitors(), 3);
        OptionManager::update(Options::urgencyAlertDaysThreshold(), 1);
        $this->postId = PostHelper::getRecentPostId();
        if (empty($this->postId)) {
            throw new \Error("Invalid post id.");
        }
        $this->SessionHandler = $this->mockSessionHandler();
        $this->PostRecentVisits = new PostRecentVisits(1, $this->SessionHandler);
    }

    private function mockSessionHandler(): SessionHandlerInterface
    {
        $SessionHandler = $this->createMock(SessionHandlerInterface::class);
        $sessionKeyIndex = 0;
        $sessionsKeys = [
            'session-test-key-00000000001',
            'session-test-key-00000000001',
            'session-test-key-00000000002',
            '',
            '',
            'session-test-key-00000000003',
            'session-test-key-00000000004',
            'session-test-key-00000000005'
        ];
        $SessionHandler->method('getSessionId')->willReturnCallback(function () use (&$sessionsKeys, &$sessionKeyIndex) {
            $value = $sessionsKeys[$sessionKeyIndex];
            $sessionKeyIndex++;
            return $value;
        });
        return $SessionHandler;
    }

    public function testRecentVisitsDataMetaKey(): void
    {
        $this->assertSame('recent_visits_data', PostRecentVisits::META_KEY);
    }

    public function testRecentVisitsCountMetaKey(): void
    {
        $this->assertSame('recent_visits_count', PostRecentVisits::RECENT_VISITS_COUNT_META_KEY);
    }

    public function testInvalidGetRecentVisitsCount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->PostRecentVisits->getRecentVisitsCount(null);
    }

    public function testUpdate()
    {
        $postId = $this->postId;
        delete_post_meta($postId, PostRecentVisits::META_KEY);
        delete_post_meta($postId, PostRecentVisits::RECENT_VISITS_COUNT_META_KEY);

        $this->PostRecentVisits->update($postId);
        $count = $this->PostRecentVisits->getRecentVisitsCount($postId);
        $this->assertIsNumeric($count);
        $this->assertSame(1, intval($count));

        $this->PostRecentVisits->update($postId);
        $count = $this->PostRecentVisits->getRecentVisitsCount($postId);
        $this->assertIsNumeric($count);
        $this->assertSame(1, intval($count));

        $this->PostRecentVisits->update($postId);
        $count = $this->PostRecentVisits->getRecentVisitsCount($postId);
        $this->assertIsNumeric($count);
        $this->assertSame(2, intval($count));

        $this->PostRecentVisits->update($postId);
    }

    public function testUpdateWithInvalidPostId()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->PostRecentVisits->update('');
    }

    public function testResetCache()
    {
        $this->assertNull($this->PostRecentVisits->resetCache($this->postId));
        $this->assertNull($this->PostRecentVisits->resetCache(''));
    }

    public function testFactory()
    {
        $urgencyAlertDaysThresholdOptionName = Options::urgencyAlertDaysThreshold();
        OptionManager::delete($urgencyAlertDaysThresholdOptionName);
        $PostRecentVisitsFactory = new PostRecentVisitsFactory();
        $this->assertTrue(OptionManager::update($urgencyAlertDaysThresholdOptionName, 1));
        $this->assertSame(1, OptionManager::get($urgencyAlertDaysThresholdOptionName));
        $PostRecentVisits = $PostRecentVisitsFactory->make();
        $this->assertInstanceOf(PostRecentVisits::class, $PostRecentVisits);
    }

    public function testFactoryWithInvalidAlertDaysThreshold(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Rezfusion Urgency Alert: Days threshold value must be greater than 0.');
        $urgencyAlertDaysThresholdOptionName = Options::urgencyAlertDaysThreshold();
        OptionManager::delete($urgencyAlertDaysThresholdOptionName);
        $this->assertNull(OptionManager::get($urgencyAlertDaysThresholdOptionName));
        $PostRecentVisitsFactory = new PostRecentVisitsFactory();
        $PostRecentVisitsFactory->make();
    }
}
