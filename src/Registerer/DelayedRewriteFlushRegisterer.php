<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Service\DelayedRewriteFlushService;

class DelayedRewriteFlushRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::init(), function () {
            return (new DelayedRewriteFlushService())->run();
        });
    }
}
