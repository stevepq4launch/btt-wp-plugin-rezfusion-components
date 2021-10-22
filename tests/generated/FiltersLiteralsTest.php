<?php

/**
 * @file Tests for filters names.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Filters;

class FiltersLiteralsTest extends BaseTestCase
{
    public function testReviewsAllowedUserRolesIsValid()
    {
        $this->assertSame(Filters::reviewsAllowedUserRoles(), 'rezfusion_reviews_allowed_user_roles');
    }

    public function testManagePostTypePostsColumnsIsValid()
    {
        $this->assertSame(Filters::managePostTypePostsColumns('test-post-type'), 'manage_test-post-type_posts_columns');
    }

    public function testPluginNameIsValid()
    {
        $this->assertSame(Filters::pluginName(), 'rezfusion_plugin_name');
    }

    public function testVariablesIsValid()
    {
        $this->assertSame(Filters::variables('test-variable'), 'variables_test-variable');
    }

}
