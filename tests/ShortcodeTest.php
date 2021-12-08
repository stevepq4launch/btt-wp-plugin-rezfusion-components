<?php

/**
 * @file - Shortcode tests.
 */

namespace Rezfusion\Tests;

use Rezfusion\Shortcodes\Shortcode;
use Rezfusion\Template;

class ShortcodeTest extends BaseTestCase
{
  public function testMissingShortcodeProperty(): void
  {
    $this->expectException(\Exception::class);
    $this->expectExceptionMessage('Invalid/missing shortcode in ' . Shortcode::class);
    $this->getMockForAbstractClass(Shortcode::class, [
      new Template('invalid-template')
    ]);
  }
}
