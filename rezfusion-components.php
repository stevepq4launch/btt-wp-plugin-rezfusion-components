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

define( 'REZFUSION_PLUGIN',  __FILE__  );
define( 'REZFUSION_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'REZFUSION_PLUGIN_ADMIN_BUILD_PATH', REZFUSION_PLUGIN_PATH . "dist/admin" );
define( 'REZFUSION_PLUGIN_TEMPLATES_PATH', REZFUSION_PLUGIN_PATH . "templates" );
define( 'REZFUSION_PLUGIN_QUERIES_PATH', REZFUSION_PLUGIN_PATH . "queries" );

require_once "includes/autoloader.php";
require_once "src/TemplateFunctions.php";

$loader = new RezfusionAutoloader();
$loader->register();
$loader->addNamespace('\\Rezfusion', REZFUSION_PLUGIN_PATH . '/src');

global $rezfusion;
$rezfusion = \Rezfusion\Plugin::getInstance();

/**
 * Helper function for retrieving plugin options values.
 * 
 * @param string $option
 * @param null $default
 * 
 * @return mixed
 */
function get_rezfusion_option($option = '', $default = null) {
    global $rezfusion;
    return $rezfusion->getOption($option, $default);
}