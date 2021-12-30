<?php

namespace Rezfusion\Registerer;

use Rezfusion\Controller\ConfigurationController;
use Rezfusion\Controller\FloorPlanController;
use Rezfusion\Controller\ItemController;
use Rezfusion\Controller\ReviewController;

class ControllersRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        foreach ([
            new ReviewController(),
            new ConfigurationController(),
            new ItemController(),
            new FloorPlanController()
        ] as $Controller) {
            $Controller->initialize();
        }
    }
}
