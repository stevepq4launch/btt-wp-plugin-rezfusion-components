<?php

namespace Rezfusion\Registerer;

use Rezfusion\Actions;
use Rezfusion\Options;

class SettingsRegisterer implements RegistererInterface
{
    /**
     * @inheritdoc
     */
    public function register(): void
    {
        add_action(Actions::adminInit(), function () {
            foreach ([
                Options::componentsURL(),
                Options::environment(),
                Options::syncItemsPostType(),
                Options::policiesGeneral(),
                Options::policiesPets(),
                Options::policiesPayment(),
                Options::policiesCancellation(),
                Options::policiesChanging(),
                Options::policiesInsurance(),
                Options::policiesCleaning(),
                Options::amenitiesFeatured(),
                Options::amenitiesGeneral(),
                Options::enableFavorites(),
                Options::repositoryToken()
            ] as $optionName) {
                register_setting(Options::optionGroup(), $optionName);
            }
        });
    }
}
