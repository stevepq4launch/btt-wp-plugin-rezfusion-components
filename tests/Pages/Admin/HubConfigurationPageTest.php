<?php

namespace Rezfusion\Tests\Pages\Admin;

use Rezfusion\Pages\Admin\HubConfigurationPage;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class HubConfigurationPageTest extends BaseTestCase
{
    public function testPageName(): void
    {
        $this->assertSame('rezfusion_components_hub_configuration', HubConfigurationPage::pageName());
    }

    public function testDisplay(): void
    {
        $HubConfigurationPage = new HubConfigurationPage(new Template(Templates::hubConfigurationTemplate()));
        $HubConfigurationPage->display();
        $this->setOutputCallback(function ($html) {
            TestHelper::assertStrings($this, $html, [
                '<button id="refresh-hub-configuration-button" class="button button-primary"><i class="fas fa-redo"></i> Refresh</button>',
                '<button id="update-hub-configuration-button" class="button button-primary"><i class="fas fa-cloud-download-alt"></i> Fetch and update configuration</button>',
                '<div class="rezfusion-configuration-container">',
                '(function($, wordpressNonce, refreshConfigurationButton, updateConfigurationButton, configurationContainer)',
                'renderConfigurationInContainer()'
            ]);
        });
    }
}
