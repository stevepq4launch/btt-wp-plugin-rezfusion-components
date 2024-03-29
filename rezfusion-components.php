<?php

/**
 * @package rezfusion_components
 * @version 0.1
 */

use Rezfusion\Factory\PluginFactory;

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

require_once REZFUSION_PLUGIN_PATH . "src/autoloader-init.php";
(new PluginFactory)->make();
