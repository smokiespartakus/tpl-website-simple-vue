<?php
// Can't really include uri_get first.. it's all a bit of a mess.
$uri = explode('/', preg_replace('/^\//', '', preg_replace('/(\?.*)$/', '', $_SERVER['REQUEST_URI'])));
$uri0 = $uri[0] ?? null;

// For ajax requests on sub, we need to include the proper index file
if ($uri0) {
	$index = sprintf('%s/%s/index.php', __DIR__, $uri0);
	if (is_file($index)) {
		require_once $index;
		exit;
	}
}

include(__DIR__ . '/../sub/index/setup.php');
require_once template_path('index.php');
