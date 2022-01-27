<?php

namespace Rezfusion\Tests;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Service\DelayedRewriteFlushService;

class DelayedRewriteFlushServiceTest extends BaseTestCase
{
    /**
     * @var DelayedRewriteFlushService
     */
    private $DelayedRewriteFlushService;

    /**
     * @var string
     */
    private $triggerRewriteFlushOptionName;

    public function setUp(): void
    {
        parent::setUp();
        $this->DelayedRewriteFlushService = new DelayedRewriteFlushService();
        $this->triggerRewriteFlushOptionName = Options::triggerRewriteFlush();
        OptionManager::delete($this->triggerRewriteFlushOptionName);
    }

    public function testRun(): void
    {
        $this->assertTrue(OptionManager::update($this->triggerRewriteFlushOptionName, true));
        $this->assertNull($this->DelayedRewriteFlushService->run());
        $this->assertFalse($this->DelayedRewriteFlushService->run());
    }

    public function testRunWithoutOptionDefined(): void
    {
        OptionManager::delete($this->triggerRewriteFlushOptionName);
        $this->assertFalse($this->DelayedRewriteFlushService->run());
    }
}
