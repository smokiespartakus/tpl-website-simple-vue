<?php

/**
 * @param $num
 * @return array|mixed|null
 */
function uri_get($num) {
	if ($num === null) return null;
	$uri = uri_array();
	return arr_get($uri, $num);
}

/**
 * Get uri as an array
 * @param int $offset array_slice offset
 * @param null $length array_slice length
 * @return array
 */
function uri_array($offset = 0, $length = null) {
	$uri = explode('/', preg_replace('/^\//', '', preg_replace('/(\?.*)$/', '', $_SERVER['REQUEST_URI'])));
	return array_slice($uri, $offset, $length);
}

/**
 * Get uri as a string
 * @param int $offset array_slice offset
 * @param int|null $length array_slice length
 * @return string|null
 */
function uri_sub($offset = 0, $length = null) {
	$uri = uri_array($offset, $length);
	if (count($uri) === 0) return null;
	return implode('/', $uri);
}

/**
 * Get from GET or POST
 * @param $key
 * @return mixed|null
 */
function get_input($key, $default = null) {
	if (isset($_GET[$key])) return $_GET[$key];
	if (isset($_POST[$key])) return $_POST[$key];
	$input = json_decode(file_get_contents('php://input'), true);
	if ($value = arr_get($input, $key)) return $value;
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

function is_ajax() {
	return is_sub_index() && uri_get(0) === 'ajax' || uri_get(1) === 'ajax';
}
