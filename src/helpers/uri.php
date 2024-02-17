<?php

/**
 * @param $num
 * @return array|mixed|null
 */
function uri_get($num) {
	if ($num === null) return null;
	$uri = explode('/', preg_replace('/^\//', '', preg_replace('/(\?.*)$/', '', $_SERVER['REQUEST_URI'])));
	return arr_get($uri, $num);
}

/**
 * Get from GET or POST
 * @param $key
 * @return mixed|null
 */
function get_input($key, $default = null) {
	if (isset($_GET[$key])) return $_GET[$key];
	if (isset($_POST[$key])) return $_POST[$key];
	return $default;
}

/**
 * Get from FILES
 * @param $key
 * @return mixed|null
 */
function get_input_file($key) {
	if (isset($_FILES[$key])) return $_FILES[$key];
	return null;
}

function uri_combine(...$paths) {
	$path = [];
	$separator = '/';
	foreach ($paths as $p) {
		if ($p === null) continue;
		$v = rtrim($p, $separator);
		if ($v) $path[] = $v;
	}
	return implode($separator, $path);
}
