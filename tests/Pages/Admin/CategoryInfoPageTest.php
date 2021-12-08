<?php

namespace Rezfusion\Tests\Pages\Admin;

use Rezfusion\Pages\Admin\CategoryInfoPage;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class CategoryInfoPageTest extends BaseTestCase
{
    public function testPageName(): void
    {
        $this->assertSame('rezfusion_components_category_info', CategoryInfoPage::pageName());
    }

    public function testDisplay(): void
    {
        $this->setOutputCallback(function ($html) {
            TestHelper::assertRegExps($this, $html, [
                '/\<h1\>Categories\<\\/h1\>/i',
                '/\<table class="form-table"\>/i',
                '/\<li\>.* \(id\: .*\)\<\/li\>/i'
            ]);
        });
        $CategoryInfoPage = new CategoryInfoPage(new Template(Templates::categoriesConfigurationPageTemplate()));
        $CategoryInfoPage->display();
    }
}
