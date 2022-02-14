<?php

namespace Rezfusion\Tests\Shortcodes;

use Rezfusion\Metas;
use Rezfusion\PostTypes;
use Rezfusion\Shortcodes\LodgingItemDetails;
use Rezfusion\Template;
use Rezfusion\Templates;
use Rezfusion\Tests\BaseTestCase;
use Rezfusion\Tests\TestHelper\TestHelper;

class LodgingItemDetailsTest extends BaseTestCase
{
    private function renderShortcode(array $attributes = []): string
    {
        $Shortcode = new LodgingItemDetails(new Template(Templates::detailsPageTemplate()));
        return $Shortcode->render($attributes);
    }

    public function testRenderFail(): void
    {
        $html = $this->renderShortcode([
            'channel' => '',
            'itemid' => ''
        ]);
        $this->assertSame("Rezfusion Lodging Item: A 'channel' and an 'itemId' attribute are both required", $html);
    }

    /**
     * Test that the shortcode renders as expected. Taking into account when a
     * developer overrides the template in their active theme.
     * 
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLodgingItem()
    {
        $posts = get_posts(['post_type' => PostTypes::listing()]);
        $meta = get_post_meta($posts[0]->ID);
        $out = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta[Metas::itemId()][0]}\"]");
        $doc = TestHelper::makeDOMDocument($out);
        $xpath = new \DOMXPath($doc);
        $this->assertEquals(1, $xpath->query('//div[@class="lodging-item"]')->length);
        foreach ([
            'lodging-item-details__beds',
            'lodging-item-details__baths',
            'lodging-item-details__occ',
            'lodging-item-details__description',
            'lodging-item-details__sleeping_arrangements',
            'lodging-item-details__amenities',
            'lodging-item-details__category-display',
            'lodging-item-details__policies',
            'lodging-item-details__reviews'
        ] as $className) {
            $this->assertEquals(1, $xpath->query('//div[@class="' . $className . '"]')->length);
        }

        // Copy the template file to the active theme.
        $activeTheme = get_stylesheet_directory();
        copy(__DIR__ . '/../../templates/vr-details-page.php', $activeTheme . '/vr-details-page.php');
        file_put_contents($activeTheme . '/vr-details-page.php', file_get_contents($activeTheme . '/vr-details-page.php') . "\nTHEME TEMPLATE");
        $out2 = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta[Metas::itemId()][0]}\"]");
        $this->assertTrue(!!stristr($out2, 'THEME TEMPLATE'));
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $template = get_stylesheet_directory() . '/vr-details-page.php';
        if (file_exists($template)) {
            unlink($template);
        }
    }
}
