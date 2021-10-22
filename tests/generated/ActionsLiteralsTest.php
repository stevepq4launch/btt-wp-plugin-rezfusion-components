<?php

/**
 * @file Tests for Actions literals.
 */

namespace Rezfusion\Tests\Generated;

use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Actions;

class ActionsLiteralsTest extends BaseTestCase
{
    public function testInit()
    {
        $this->assertSame('init', Actions::init());
    }

    public function testAdminEnqueueScripts()
    {
        $this->assertSame('admin_enqueue_scripts', Actions::adminEnqueueScripts());
    }

    public function testWpHead()
    {
        $this->assertSame('wp_head', Actions::wpHead());
    }

    public function testAdminInit()
    {
        $this->assertSame('admin_init', Actions::adminInit());
    }

    public function testTemplateRedirect()
    {
        $this->assertSame('template_redirect', Actions::templateRedirect());
    }

    public function testAdminNotices()
    {
        $this->assertSame('admin_notices', Actions::adminNotices());
    }

    public function testRestAPI_Init()
    {
        $this->assertSame('rest_api_init', Actions::restAPI_Init());
    }

    public function testWpFooter()
    {
        $this->assertSame('wp_footer', Actions::wpFooter());
    }

    public function testAdminMenu()
    {
        $this->assertSame('admin_menu', Actions::adminMenu());
    }

    public function testAddMetaBoxes()
    {
        $this->assertSame('add_meta_boxes', Actions::addMetaBoxes());
    }

    public function testSavePost()
    {
        $this->assertSame('save_post', Actions::savePost());
    }

    public function testTaxonomyAddFormFields()
    {
        $this->assertSame('taxonomy-test_add_form_fields', Actions::taxonomyAddFormFields('taxonomy-test'));
    }

    public function testCreatedTaxonomy()
    {
        $this->assertSame('created_taxonomy-test', Actions::createdTaxonomy('taxonomy-test'));
    }

    public function testTaxonomyEditFormFields()
    {
        $this->assertSame('taxonomy-test_edit_form_fields', Actions::taxonomyEditFormFields('taxonomy-test'));
    }

    public function testEditedTaxonomy()
    {
        $this->assertSame('edited_taxonomy-test', Actions::editedTaxonomy('taxonomy-test'));
    }

    public function testManagePostTypePostsCustomColumn()
    {
        $this->assertSame('manage_test-post-type_posts_custom_column', Actions::managePostTypePostsCustomColumn('test-post-type'));
    }

    public function testEnqueueScripts()
    {
        $this->assertSame('wp_enqueue_scripts', Actions::enqueueScripts());
    }

}
