<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Options;
use Rezfusion\Plugin;
use Rezfusion\Provider\OptionsHandlerProvider;
use Rezfusion\Service\DeleteDataService;
use Rezfusion\Shortcodes\FeaturedProperties;
use Rezfusion\Shortcodes\Shortcode;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\PropertiesHelper;
use Rezfusion\Tests\TestHelper\TestHelper;

class FeaturedPropertiesTest extends BaseTestCase
{
    private function makeShortcode(): Shortcode
    {
        return new FeaturedProperties(new Template(Templates::featuredPropertiesTemplate()));
    }

    private function prepareRenderTest(): void
    {
        (new DeleteDataService)->run();
        Plugin::getInstance()->refreshData();
    }

    public function testMaxPropertiesCount(): void
    {
        $this->assertSame(6, TestHelper::callClassMethod($this->makeShortcode(), 'maxPropertiesCount'));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRender(): void
    {
        $this->prepareRenderTest();
        $Shortcode = $this->makeShortcode();
        OptionsHandlerProvider::getInstance()->updateOption(
            Options::featuredPropertiesIds(),
            array_merge(PropertiesHelper::makeIdsArray(), PropertiesHelper::makeIdsArray())
        );
        $html = $Shortcode->render([]);
        TestHelper::assertRegExps($this, $html, [
            '/\<span class="property-details__beds">Beds .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<span class="property-details__baths">Baths .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<span class="property-details__sleeps">Sleeps .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<figure class="featured-properties__image"\>/i',
            '/\<article class="featured-properties__card flex-row flex-xs-12 flex-sm-6 flex-md-4 flex-xs-center"\>/i',
            '/\<a href="http:\/\/.*?vr_listing=.*" class="featured-properties__link flex-row flex-xs-center"\>/i'
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRenderWithoutPropertiesDefined(): void
    {
        $this->prepareRenderTest();
        $Shortcode = $this->makeShortcode();
        OptionsHandlerProvider::getInstance()->updateOption(
            Options::featuredPropertiesIds(),
            json_encode([])
        );
        $html = $Shortcode->render([]);
        TestHelper::assertRegExps($this, $html, [
            '/\<span class="property-details__beds">Beds .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<span class="property-details__baths">Baths .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<span class="property-details__sleeps">Sleeps .*\<em class="bar"\>|\<\/em\>\<\/span\>/i',
            '/\<figure class="featured-properties__image"\>/i',
            '/\<article class="featured-properties__card flex-row flex-xs-12 flex-sm-6 flex-md-4 flex-xs-center"\>/i',
            '/\<a href="http:\/\/.*?vr_listing=.*" class="featured-properties__link flex-row flex-xs-center"\>/i'
        ]);
    }
}
