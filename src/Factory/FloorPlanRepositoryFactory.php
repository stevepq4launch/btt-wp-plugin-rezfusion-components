<?php

namespace Rezfusion\Factory;

use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Repository\FloorPlanRepository;

class FloorPlanRepositoryFactory implements MakeableInterface
{
    public function make(): FloorPlanRepository
    {
        return new FloorPlanRepository(Plugin::apiClient(), get_rezfusion_option(Options::hubChannelURL()));
    }
}
