<?php

/**
 * @file Tests for PostRecentVisitsTest.
 */

namespace Rezfusion\Tests;

use InvalidArgumentException;
use Rezfusion\Factory\API_ClientFactory;
use Rezfusion\Factory\PostRecentVisitsFactory;
use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\PostRecentVisits;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\SessionHandler\SessionHandlerInterface;

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

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        Plugin::refreshData();
    }

    public function setUp(): void
    {
        parent::setUp();
        /** Required for properly executing tests. */
        $this->eraseData();
        OptionsHandlerProvider::getInstance()->updateOption(Options::urgencyAlertDaysThreshold(), 1);
        $this->postId = $this->findPostIdForTests();
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

    private function eraseData()
    {
        global $wpdb;
        // $wpdb->query("DELETE FROM wp_postmeta WHERE meta_key = '" . PostRecentVisits::META_KEY . "';");
    }

    private function findPostIdForTests(): int
    {
        $items = (new ItemRepository((new API_ClientFactory())->make()))->getAllItems();
        return intval(@$items[0]['post_id']);
    }

    public function testInvalidGetRecentVisitsCount()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->PostRecentVisits->getRecentVisitsCount(null);
    }

    public function testUpdate()
    {
        $postId = $this->postId;

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
        OptionManager::update(Options::urgencyAlertDaysThreshold(), 1);
        (new PostRecentVisitsFactory())->make();
        OptionManager::update(Options::urgencyAlertDaysThreshold(), 0);
        $this->expectException(\Exception::class);
        (new PostRecentVisitsFactory())->make();
    }
}
