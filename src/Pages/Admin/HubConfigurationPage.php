<?php

/**
 * @file - Renders page with hub configuration.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;

class HubConfigurationPage extends Page
{

    /**
     * @var string
     */
    const PAGE_NAME = 'rezfusion_components_hub_configuration';

    /**
     * @return void
     */
    public function display(): void
    {
        print $this->template->render([]);
    }
}
