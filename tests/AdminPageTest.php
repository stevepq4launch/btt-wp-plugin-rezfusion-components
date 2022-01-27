<?php

namespace Rezfusion\Tests;

use Rezfusion\Actions;
use Rezfusion\Plugin;

class AdminPageTest extends BaseTestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testActions()
    {
        $this->setOutputCallback(function () {
        });
        Plugin::getInstance();
        $allActions = [
            Actions::adminInit(),
            Actions::wpHead(),
            Actions::templateRedirect(),
            Actions::adminEnqueueScripts()
        ];
        foreach ($allActions as $action) {
            do_action($action);
        }
        $this->assertTrue(true);
    }
}
