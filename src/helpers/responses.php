<?php

function error_response($message, $code = 500) {
	http_response_code($code);
	header('Content-Type: application/json');
	echo json_encode(['error' => $message]);
	exit;
}
function error_404($message = 'Not Found') {
	http_response_code(404);
	header('Content-Type: application/json');
	echo json_encode(['error' => $message]);
	exit;
}
