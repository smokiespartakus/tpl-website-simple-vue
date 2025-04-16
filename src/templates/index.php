<?php

if (environment('local'))
	define('VERSION', config('version.VERSION', '1') . '-' . time());
else
	define('VERSION', config('version.VERSION', '1') );

if (is_sub_index() && uri_get(0) === 'ajax' || uri_get(1) === 'ajax') {
	require_once template_path('ajax.php');
	exit;
}

$page = 'main.php';

/*
// Use this for php paging
$page = uri_get(0);
if (!$page) $page = 'index.php';
else $page .= '.php';
*/

$pagePath = local_view_path($page);
if (file_exists($pagePath)) {
	require_once $pagePath;
} else {
	require_once local_view_path('errors', '404.php');
}
