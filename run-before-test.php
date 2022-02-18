<?php

/**
 * @file Executes what's required before running tests.
 */

use Rezfusion\Tests\TestHelper\BootstrapHelper;

require_once(__DIR__ . "/vendor/autoload.php");
require_once(__DIR__ . '/../../../wp-config.php');
BootstrapHelper::bootstrap();
