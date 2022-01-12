<?php

namespace Rezfusion\Registerer;

use Rezfusion\Configuration\ConfigurationStorage\RemoteConfigurationStorage;
use Rezfusion\Configuration\HubConfigurationProvider;
use Rezfusion\Configuration\HubConfigurationUpdater;
use Rezfusion\Controller\ConfigurationController;
use Rezfusion\Controller\FloorPlanController;
use Rezfusion\Controller\ItemController;
use Rezfusion\Controller\ReviewController;
use Rezfusion\Plugin;
use Rezfusion\Repository\ReviewRepository;

class ControllersRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        foreach ([
            new ReviewController(new ReviewRepository),
            new ConfigurationController(
                $Configuration = HubConfigurationProvider::getInstance(),
                new HubConfigurationUpdater(
                    $Configuration,
                    new RemoteConfigurationStorage($Configuration->getComponentsURL(), get_class($Configuration))
                )
            ),
            new ItemController(function () {
                Plugin::getInstance()::refreshData();
            }),
            new FloorPlanController()
        ] as $Controller) {
            $Controller->initialize();
        }
    }
}
