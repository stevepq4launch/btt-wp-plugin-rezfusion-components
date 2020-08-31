<?php
/**
 * @file - Provide a base class that fixes some issues w WP.
 */

namespace Rezfusion\Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase {

  public function tearDown(): void {
    parent::tearDown();
    // https://github.com/sebastianbergmann/php-code-coverage/issues/708
    $_SERVER['REQUEST_TIME'] = (int) $_SERVER['REQUEST_TIME'];
  }

}
