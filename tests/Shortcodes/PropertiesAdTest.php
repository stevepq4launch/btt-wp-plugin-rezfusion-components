<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Plugin;
use Rezfusion\Repository\ItemRepository;
use Rezfusion\Shortcodes\PropertiesAd;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class PropertiesAdTest extends BaseTestCase
{
    private function doRenderTest(array $attributes = []): void
    {
        $Shortcode = new PropertiesAd(new Template(Templates::propertiesAdTemplate()));
        $html = $Shortcode->render($attributes);
        $this->assertNotEmpty($html);
        $DOMXPath = TestHelper::makeDOMXPath($html);
        TestHelper::assertElementWithClassExists($this, $DOMXPath, 'properties-ad');
        TestHelper::assertClassesCount($this, $DOMXPath, 'properties-ad__card', 3);
    }

    public function testRenderWithRandomPosts(): void
    {
        $this->doRenderTest([
            PropertiesAd::INCLUDE_DETAILS_ATTR_KEY => true
        ]);
    }

    public function testRenderWithDefinedPropertiesIds()
    {
        $this->doRenderTest([
            PropertiesAd::INCLUDE_DETAILS_ATTR_KEY => true,
            'itemids' => join(',', PropertiesHelper::makeIdsArray())
        ]);
    }

    public function testRenderWithDefinedPostsIds()
    {
        $postsIds = array_map(function ($item) {
            return $item['post_id'];
        }, (new ItemRepository(Plugin::apiClient()))->getAllItems());
        $this->assertNotEmpty($postsIds);
        $this->assertGreaterThan(3, $postsIds);
        $this->doRenderTest([
            PropertiesAd::INCLUDE_DETAILS_ATTR_KEY => true,
            'itemids' => join(',', PropertiesHelper::makeIdsArray()),
            'pids' => join(',', $postsIds)
        ], 3);
    }
}
