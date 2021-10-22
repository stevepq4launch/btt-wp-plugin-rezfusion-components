<?php

/**
 * @file Tests for pages names.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;

class PagesNamesTest extends BaseTestCase
{
    public function testConfigurationPageIsValid()
    {
        $this->assertSame('rezfusion_components_config', \Rezfusion\Pages\Admin\ConfigurationPage::pageName());
    }

    public function testCategoryInfoPageIsValid()
    {
        $this->assertSame('rezfusion_components_category_info', \Rezfusion\Pages\Admin\CategoryInfoPage::pageName());
    }

    public function testHubConfigurationPageIsValid()
    {
        $this->assertSame('rezfusion_components_hub_configuration', \Rezfusion\Pages\Admin\HubConfigurationPage::pageName());
    }

    public function testItemInfoPageIsValid()
    {
        $this->assertSame('rezfusion_components_item_info', \Rezfusion\Pages\Admin\ItemInfoPage::pageName());
    }

    public function testReviewsListPageIsValid()
    {
        $this->assertSame('rezfusion_components_reviews_list', \Rezfusion\Pages\Admin\ReviewsListPage::pageName());
    }

}
