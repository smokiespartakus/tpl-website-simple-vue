<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

include __DIR__ . '/src/helpers/paths.php';
include helper_path('array.php');
include helper_path('system.php');
include helper_path('uri.php');
include helper_path('config.php');
include helper_path('mix.php');
include include_path('register_shutdown.php');

if(defined('SUB_NAME')) {
	env_load();
	config_load();
}

spl_autoload_register(function ($className) {
	if (defined('SUB_NAME') && file_exists(local_base_path('classes', $className . '.php'))) {
		include local_base_path('classes', $className . '.php');
		return;
	}
	include class_path($className . '.php');
});
