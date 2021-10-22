<?php

require_once REZFUSION_PLUGIN_PATH . "includes/autoloader.php";
$RezfusionAutoloader = new RezfusionAutoloader();
$RezfusionAutoloader->register();
$RezfusionAutoloader->addNamespace('\\Rezfusion', REZFUSION_PLUGIN_PATH . '/src');
