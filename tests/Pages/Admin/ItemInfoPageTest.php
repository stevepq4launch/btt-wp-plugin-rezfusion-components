<?php

namespace Rezfusion\Tests\Pages\Admin;

use Rezfusion\Pages\Admin\ItemInfoPage;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class ItemInfoPageTest extends BaseTestCase
{
    public function testPageName(): void
    {
        $this->assertSame('rezfusion_components_item_info', ItemInfoPage::pageName());
    }

    public function testDisplay(): void
    {
        $ItemInfoPage = new ItemInfoPage(new Template(Templates::itemsConfigurationPageTemplate()));
        $ItemInfoPage->display();
        $this->setOutputCallback(function ($html) {
            TestHelper::assertStrings($this, $html, [
                '<table class="form-table">',
            ]);
            $regExps = array_map(function ($property) {
                return '/\<td\>\s*' . $property[PropertiesHelper::propretyIdKey()] . '\s*\<\/td\>/i';
            }, PropertiesHelper::properties());
            TestHelper::assertRegExps($this, $html, $regExps);
        });
    }
}
