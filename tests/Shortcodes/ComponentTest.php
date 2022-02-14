<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Exception\ComponentsBundleURL_RequiredException;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;
use Rezfusion\Shortcodes\Component;
use Rezfusion\Taxonomies;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PostHelper;
use Rezfusion\Tests\TestHelper\PropertiesHelper;

class ComponentTest extends BaseTestCase
{
    public function renderShortcode(array $attributes = []): string
    {
        $Component = new Component(new Template(Templates::componentTemplate()));
        return $Component->render($attributes);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithInvalidAttributes(): void
    {
        $html = $this->renderShortcode([
            'channel' => '',
            'url' => ''
        ]);
        $this->assertSame("Rezfusion Component: A 'channel' and a 'URL' attribute are both required", $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithMissingComponentsBundleURL(): void
    {
        global $rezfusion;
        $rezfusion = $this->createMock(Plugin::class);
        $rezfusion->method('getOption')->willReturn('');
        $this->expectException(ComponentsBundleURL_RequiredException::class);
        $this->renderShortcode([
            'channel' => true,
            'url' => true
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testSearchRender(): void
    {
        $html = $this->renderShortcode([
            'element' => 'search'
        ]);
        $this->assertSame("<div id=\"app\"></div>\n", $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDetailsPageRender(): void
    {
        global $post;
        $post = PostHelper::getRecentPost();
        $html = $this->renderShortcode([
            'element' => 'details-page'
        ]);
        $this->assertSame("<div id=\"app\"></div>\n", $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithPromoPost(): void
    {
        global $post;
        $postID = PostHelper::insertPromoPost('test', [PropertiesHelper::getRandomPropertyId()]);
        $this->assertNotEmpty($postID);
        $post = get_post($postID);
        $html = $this->renderShortcode([
            'element' => 'details-page'
        ]);
        $this->assertSame("<div id=\"app\"></div>\n", $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithTaxonomy(): void
    {
        $terms = get_terms(['taxonomy' => Taxonomies::amenities(), 'hide_empty' => 0]);
        $termId = @$terms[0]->term_id;
        $this->assertNotEmpty($termId);
        $this->assertIsNumeric($termId);
        global $wp_query;
        $wp_query = new \WP_Query([
            'post_type' => PostTypes::listing(),
            'tax_query' => [[
                'taxonomy' => Taxonomies::amenities(),
                'field' => 'id',
                'terms' => $termId
            ]]
        ]);
        $html = $this->renderShortcode([
            'element' => 'details-page'
        ]);
        $this->assertSame("<div id=\"app\"></div>\n", $html);
    }

    // public function tearDown(): void
    // {
    //     parent::tearDown();
    //     if (!empty($this->originalChannelURL)) {
    //         OptionManager::update(Options::hubChannelURL(), $this->originalChannelURL);
    //     }
    // }
}
