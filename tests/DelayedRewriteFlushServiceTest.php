<?php

namespace Rezfusion\Tests;

use Rezfusion\Helper\OptionManager;
use Rezfusion\Options;
use Rezfusion\Service\DelayedRewriteFlushService;

class DelayedRewriteFlushServiceTest extends BaseTestCase
{
    public function testRun()
    {
        $DelayedRewriteFlushService = new DelayedRewriteFlushService();
        $this->assertFalse(OptionManager::update(Options::triggerRewriteFlush(), false));
        $DelayedRewriteFlushService->run();
        $this->assertTrue(OptionManager::update(Options::triggerRewriteFlush(), true));
        $DelayedRewriteFlushService->run();
    }
}
