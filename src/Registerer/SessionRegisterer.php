<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Plugin;

class SessionRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::init(), function () {
            Plugin::getInstance()->initializeSession();
        });
    }
}
