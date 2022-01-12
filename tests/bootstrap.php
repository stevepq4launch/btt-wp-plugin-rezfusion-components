<?php

use Rezfusion\Service\DeleteDataService;

define('REZFUSION_TEST', true);
require_once(__DIR__ . "/../vendor/autoload.php");
// require_once(__DIR__ . "/../../../../wp-load.php");
// require_once(__DIR__ . "/../../../../wp-settings.php");
// DeleteDataService::unlock();

/*
 * To avoid 'Call to undefined function get_current_screen()' in
 * wp-admin/includes/class-wp-site-health.php
 */
function get_current_screen()
{
}
