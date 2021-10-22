<?php

namespace Rezfusion\Registerer;

use Rezfusion\Factory\PluginUpdaterFactory;
use Rezfusion\OptionsHandler;

class PluginUpdateRegisterer implements RegistererInterface
{
    /**
     * @var OptionsHandler
     */
    private $OptionsHandler;

    /**
     * @param OptionsHandler $OptionsHandler
     */
    public function __construct(OptionsHandler $OptionsHandler)
    {
        $this->OptionsHandler = $OptionsHandler;
    }

    /**
     * @inheritdoc
     */
    public function register(): void
    {
        (new PluginUpdaterFactory($this->OptionsHandler))->make();
    }
}
