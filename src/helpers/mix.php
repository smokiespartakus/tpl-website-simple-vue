<?php
/**
 * Mix asset path.
 * @param $path
 * @param $return
 * @return string|void
 */
function mix($path, $return = false) {
	if (SUB_NAME === 'index') $p = '/' . ltrim($path, '/');
	else $p = uri_combine('/' . SUB_NAME, ltrim($path, '/'));
	if ($return) return $p;
	echo $p;
}

/**
 * Mix versioned asset path.
 * @param $path
 * @param $return
 * @return string|void
 */
function mixv($path, $return = false) {
	$version = defined('VERSION') ? VERSION : '1';
	if ($return) return mix($path, true) . '?v=' . $version;
	echo mix($path, true) . '?v=' . $version;
}
