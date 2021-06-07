<?php
/**
 * @file - Shortcode render tests.
 */

namespace Rezfusion\Tests;


use Rezfusion\Plugin;

class ShortcodeTest extends BaseTestCase {

  /**
   * Test that the shortcode renders as expected. Taking into account when a
   * developer overrides the template in their active theme.
   */
  public function testLodgingItem() {
    Plugin::refreshData();
    $posts = get_posts(['post_type' => 'vr_listing']);
    $meta = get_post_meta($posts[0]->ID);
    $out = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta['rezfusion_hub_item_id'][0]}\"]");
    $doc = new \DOMDocument();
    $doc->loadXML($out);
    $xpath = new \DOMXPath($doc);
    $wrappers = $xpath->query('//div[contains(@class,"lodging-item")]');
    $this->assertEquals(11, $wrappers->length);
    $beds = $xpath->query('//div[contains(@class, "lodging-item-details__beds")]');
    $this->assertEquals(1, $beds->length);
    $baths = $xpath->query('//div[contains(@class, "lodging-item-details__baths")]');
    $this->assertEquals(1, $baths->length);

    // Copy the template file to the active theme.
    $activeTheme = get_stylesheet_directory();
    copy(__DIR__ . '/../templates/vr-details-page.php', $activeTheme . '/vr-details-page.php');
    file_put_contents($activeTheme . '/vr-details-page.php', file_get_contents($activeTheme . '/vr-details-page.php') . "\nTHEME TEMPLATE");
    $out2 = do_shortcode("[rezfusion-lodging-item itemid=\"{$meta['rezfusion_hub_item_id'][0]}\"]");
    $this->assertTrue(!!stristr($out2, 'THEME TEMPLATE'));

  }

  public function tearDown(): void {
    parent::tearDown();
    $activeTheme = get_stylesheet_directory();
    unlink($activeTheme . '/vr-details-page.php');
  }

}
