<?php

$file = uri_get(2);
$path = local_ajax_path($file . '.ajax.php');
if (!is_file($path)) $result = ['error' => 'No ajax file: ' . $file];
else $result = require_once $path;

if (is_array($result)) {
	header('Content-Type: application/json');
	echo json_encode($result);
} else if ($result) {
	header('Content-Type: text/plain');
	echo $result;
}

