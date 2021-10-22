<?php

namespace Rezfusion\Tests;

use ReflectionClass;
use Rezfusion\Helper\AssetsRegistererInterface;
use Rezfusion\OptionsHandler;
use Rezfusion\Plugin;
use Rezfusion\Registerer\RegisterersContainer;
use Rezfusion\SessionHandler\SessionHandlerInterface;

class ConstructablePlugin
{
    /**
     * Creates a new instance of Plugin.
     * 
     * @param OptionsHandler $OptionsHandler
     * @param SessionHandlerInterface $SessionHandler
     * @param AssetsRegistererInterface $AssetsRegisterer
     * @param RegisterersContainer $RegisterersContainer
     * 
     * @return Plugin
     */
    public function make(
        OptionsHandler $OptionsHandler,
        SessionHandlerInterface $SessionHandler,
        AssetsRegistererInterface $AssetsRegisterer,
        RegisterersContainer $RegisterersContainer
    ): Plugin {
        $class = new ReflectionClass(Plugin::class);
        $constructor = $class->getConstructor();
        $constructor->setAccessible(true);
        $object = $class->newInstanceWithoutConstructor();
        $constructor->invoke(
            $object,
            $OptionsHandler,
            $SessionHandler,
            $AssetsRegisterer,
            $RegisterersContainer
        );
        return $object;
    }
}
