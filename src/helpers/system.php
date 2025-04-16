<?php

/**
 * Dump values
 * @param mixed ...$values
 */
function dump(...$values) {
	foreach ($values as $val) {
		if (php_sapi_name() == "cli") {
			var_export($val);
			echo PHP_EOL;
		} else {
			var_export($val);
			echo '<br />';
		}
	}
}

/**
 * Dump and die
 * @param mixed ...$values
 */
function dd(...$values) {
	dump(...$values);
	die();
}
$_ENVIRONMENT = null;
function env_load() {
	global $_ENVIRONMENT;
	if (!file_exists(local_base_path('env.php'))) {
		throw new Exception('env.php not found');
	}
	$_ENVIRONMENT = include(local_base_path('env.php')) ?? [];
}

/**
 * Get value from SERVER. THIS REQUIRES DOTENV
 * @param $key
 * @param null $default
 * @return mixed|null
 * @throws Exception
 */
function env($key, $default = null) {
	global $_ENVIRONMENT;
	if (!$_ENVIRONMENT === null) {
		throw new Exception('env_init() must be called before env()');
	}
	return arr_get($_ENVIRONMENT, $key, $default);
}

/**
 * Get current environment or compare with value.
 * @return bool|string
 */
function environment($compare = null) {
	if ($compare) return $compare == env('APP_ENV');
	return env('APP_ENV');
}

/**
 * exit() with json encoded $arguments
 */
function jexit() {
	$args = func_get_args();
	if (count($args) == 1)
		exit(json_encode($args[0]));
	else
		exit(json_encode($args));
}

/**
 * Echo (or return) variable as a string in a pretty way.
 * @param $val value to dump
 * @param bool $return return value instead of echoing
 * @return string
 */
function pretty_dump($val, $return = false) {
	$str = '';
	if (is_null($val)) $str = 'null';
	else if ($val === false) $str = 'false';
	else if ($val === true) $str = 'true';
	else if (is_array($val)) $str = json_encode($val);
	else $str = $val . '';
	if ($return) return $str;
	echo $str;
}

function logger() {
	return Logger::instance();
}

function has_sub() {
	return defined('SUB_NAME');
}

function is_sub_index() {
	return has_sub() && SUB_NAME === 'index';
}

