<?php

namespace Rezfusion\Factory;

use Rezfusion\Plugin;

class PluginFactory
{
    /**
     * Creates a new instance of Rezfusion Plugin.
     * @return Plugin
     */
    public function make(): Plugin
    {
        global $rezfusion;
        if (empty($rezfusion)) {
            $rezfusion = Plugin::getInstance();
        }
        return $rezfusion;
    }
}
