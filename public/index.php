<?php
include(__DIR__ . '/../sub/index/setup.php');

/*
if ($uri0 = uri_get(0)) {
	$index = sprintf('%s/%s/index.php', __DIR__, $uri0);
	if (is_file($index)) {
		require_once $index;
		exit;
	}
}
*/

require_once template_path('index.php');
