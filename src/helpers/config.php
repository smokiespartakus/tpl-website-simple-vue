<?php
$_CONFIG = null;
/**
 * @param $key
 * @param $default
 * @return array|mixed|null
 * @throws Exception
 */
function config($key, $default = null) {
	global $_CONFIG;
	if ($_CONFIG === null) {
		throw new Exception('config() called before load_config()');
	}
	return arr_get($_CONFIG, $key, $default);
}

/**
 * Load config files into $_CONFIG for a given path
 * @param $path
 * @return void
 */
function config_load() {
	global $_CONFIG;
	$files = glob(local_config_path('*'));
	$config = [];
	foreach ($files as $file) {
		$f = basename($file);
		$data = include(local_config_path($f));
		$config[preg_replace('/\.php$/', '', $f)] = $data;
	}
	$_CONFIG = $config;
}
