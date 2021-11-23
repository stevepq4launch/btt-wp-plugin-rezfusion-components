<?php
/**
 * @file - Shortcode render tests.
 */

namespace Rezfusion\Tests;

use Rezfusion\Metas;
use Rezfusion\Plugin;
use Rezfusion\PostTypes;

class ShortcodeTest extends BaseTestCase {

  private function createDOM_Document($xml = ''){
    $Document = new \DOMDocument();
    libxml_use_internal_errors(true);
    $Document->loadHTML($xml);
    libxml_use_internal_errors(false);
    return $Document;
  }

  /**
   * Test that the shortcode renders as expected. Taking into account when a
   * developer overrides the template in their active theme.
   */
  public function testLodgingItem() {
    Plugin::refreshData();
    $posts = get_posts(['post_type' => PostTypes::listing()]);
    $meta = get_post_meta($posts[0]->ID);
    $out = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta[Metas::itemId()][0]}\"]");
    $doc = $this->createDOM_Document($out);
    $xpath = new \DOMXPath($doc);
    $wrappers = $xpath->query('//div[contains(@class,"lodging-item")]');
    $this->assertEquals(16, $wrappers->length);
    $beds = $xpath->query('//div[contains(@class, "lodging-item-details__beds")]');
    $this->assertEquals(1, $beds->length);
    $baths = $xpath->query('//div[contains(@class, "lodging-item-details__baths")]');
    $this->assertEquals(1, $baths->length);

    // Copy the template file to the active theme.
    $activeTheme = get_stylesheet_directory();
    copy(__DIR__ . '/../templates/vr-details-page.php', $activeTheme . '/vr-details-page.php');
    file_put_contents($activeTheme . '/vr-details-page.php', file_get_contents($activeTheme . '/vr-details-page.php') . "\nTHEME TEMPLATE");
    $out2 = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta[Metas::itemId()][0]}\"]");
    $this->assertTrue(!!stristr($out2, 'THEME TEMPLATE'));

  }

  public function tearDown(): void {
    parent::tearDown();
    $activeTheme = get_stylesheet_directory();
    unlink($activeTheme . '/vr-details-page.php');
  }

}
