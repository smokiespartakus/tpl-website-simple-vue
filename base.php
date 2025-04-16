<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

require_once __DIR__ . '/src/helpers/paths.php';
require_once helper_path('uri.php');
require_once helper_path('responses.php');
require_once helper_path('mix.php');
require_once helper_path('array.php');
require_once helper_path('system.php');
require_once helper_path('config.php');
require_once helper_path('strings.php');

include include_path('register_shutdown.php');

if(has_sub()) {
	env_load();
	config_load();
}

spl_autoload_register(function ($className) {
	if (has_sub() && file_exists(local_class_path($className . '.php'))) {
		include local_class_path($className . '.php');
		return;
	}
	include class_path($className . '.php');
});
