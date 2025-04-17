<?php
/*
 * Initialize the application
 */
require_once __DIR__ . '/helpers/paths.php';
require_once helper_path('uri.php');
require_once helper_path('array.php');
require_once helper_path('system.php');
require_once helper_path('responses.php');

// Define SUB_NAME
$uri0 = uri_get(0);
if ($uri0 === '' || preg_match('/[^a-zA-Z0-9\-_]/', $uri0)) {
	$uri0 = null;
}
if ($uri0 === null) {
	define('SUB_NAME', 'index');
} else if (is_dir(sub_path($uri0))) {
	$subPath = realpath(sub_path($uri0));
	$basePath = realpath(base_path());
	if (substr($subPath, 0, strlen($basePath)) !== $basePath) {
		error_404();
	}
	define('SUB_NAME', $uri0);
} else {
	error_404();
}

require_once src_path('base.php');

require_once local_base_path('setup.php');
