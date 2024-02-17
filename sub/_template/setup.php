<?php
/**
 * Update this to reflect the name of your util.
 */
const SUB_NAME = '_template';

include_once __DIR__ . '/../../base.php';

env_load(local_base_path('env.php'));
config_load(SUB_NAME);

spl_autoload_register(function ($className) {
	if (file_exists(local_base_path('classes', $className . '.php'))) {
		include local_base_path('classes', $className . '.php');
	}
	include class_path($className . '.php');
});
