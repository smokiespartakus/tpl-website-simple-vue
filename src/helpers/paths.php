<?php

function base_path(...$path) {
	return path_combine(__DIR__, '..', '..', ...$path);
}

function src_path(...$path) {
	return base_path('src', ...$path);
}

function helper_path(...$path) {
	return src_path('helpers', ...$path);
}

function storage_path(...$path) {
	return base_path('storage', ...$path);
}

function include_path(...$path) {
	return src_path('includes', ...$path);
}

function env_path(...$path) {
	return base_path('env', ...$path);
}

function public_path(...$path) {
	return base_path('public', ...$path);
}

function setup_path(...$path) {
	return base_path('setup', ...$path);
}

function config_path(...$path) {
	return base_path('config', ...$path);
}

function class_path(...$path) {
	return src_path('classes', ...$path);
}

function log_path(...$path) {
	return storage_path('logs', ...$path);
}

function sub_path(...$path) {
	return base_path('sub', ...$path);
}
function template_path(...$path) {
	return src_path('templates', ...$path);
}

/*
 * LOCAL paths
 */
function local_public_path(...$path) {
	if (!defined('SUB_NAME')) {
		throw new Exception('SUB_NAME is not defined');
	}
	if (SUB_NAME === 'index') return public_path(...$path);
	return public_path(SUB_NAME, ...$path);
}
function local_base_path(...$path) {
	if (!defined('SUB_NAME')) {
		throw new Exception('SUB_NAME is not defined');
	}
	return sub_path(SUB_NAME, ...$path);
}
function local_ajax_path(...$path) {
	return local_base_path('ajax', ...$path);
}

function local_helper_path(...$path) {
	return local_base_path('helpers', ...$path);
}

function local_inc_path(...$path) {
	return local_base_path('inc', ...$path);
}

function local_view_path(...$path) {
	return local_base_path('views', ...$path);
}

function local_class_path(...$path) {
	return local_base_path('classes', ...$path);
}

function local_storage_path(...$path) {
	return local_base_path('storage', ...$path);
}

function local_log_path(...$path) {
	return local_storage_path('logs', ...$path);
}

function local_config_path(...$path) {
	return local_base_path('config', ...$path);
}


function path_combine(...$paths) {
	$path = [];
	foreach ($paths as $p) {
		if ($p === null) continue;
		$v = rtrim($p, DIRECTORY_SEPARATOR);
		if ($v) $path[] = $v;
	}
	return implode(DIRECTORY_SEPARATOR, $path);
}
