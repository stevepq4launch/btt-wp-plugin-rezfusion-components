<?php

/**
 * @package rezfusion_components
 * @version 0.1
 */
/*
Plugin Name: Rezfusion Components
Plugin URI: https://bluetent.com/
Description Embed RezFusion components on your WordPress site.
Author: developers@bluetent.com
Version: 0.1
Author URI: https://bluetent.com
*/

define( 'REZFUSION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'REZFUSION_PLUGIN_ADMIN_BUILD_PATH', plugin_dir_path( __FILE__ ) . "dist/admin" );
define( 'REZFUSION_PLUGIN_TEMPLATES_PATH', plugin_dir_path( __FILE__ ) . "templates" );
define( 'REZFUSION_PLUGIN_QUERIES_PATH', plugin_dir_path( __FILE__ ) . "queries" );

require_once "includes/autoloader.php";

$loader = new RezfusionAutoloader();
$loader->register();
$loader->addNamespace('\\Rezfusion', REZFUSION_PLUGIN_PATH . '/src');

global $rezfusion;
$rezfusion = \Rezfusion\Plugin::getInstance();
