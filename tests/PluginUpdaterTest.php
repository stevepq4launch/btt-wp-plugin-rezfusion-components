<?php

namespace Rezfusion\Tests;

use Rezfusion\Factory\PluginUpdaterFactory;
use Rezfusion\OptionsHandler;

class PluginUpdaterTest extends BaseTestCase
{
    public function testInvalidParameters()
    {
        $OptionsHandler = $this->createMock(OptionsHandler::class);
        $OptionsHandler->method('getOption')->willReturn(null);
        $PluginUpdater = (new PluginUpdaterFactory($OptionsHandler))->make();
        $this->assertNull($PluginUpdater);
    }
}
