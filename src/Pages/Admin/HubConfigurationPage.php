<?php

/**
 * @file - Renders page with hub configuration.
 */

namespace Rezfusion\Pages\Admin;

use Rezfusion\Pages\Page;

class HubConfigurationPage extends Page
{

    /**
     * @return void
     */
    public function display()
    {
        print $this->template->render([]);
    }
}
