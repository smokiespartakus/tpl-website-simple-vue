<?php

function create_random_string($len, $nums = true, $lower = true, $upper = true, $special = false) {
	$chars = '';
	if ($nums) $chars .= '0123456789';
	if ($lower) $chars .= 'abcdefghijklmnopqrstuvwxyz';
	if ($upper) $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if ($special) $chars .= '!@#$%^&*()_+';
	$charsLen = strlen($chars);
	$result = '';
	for ($i = 0; $i < $len; $i++) {
		$result .= $chars[rand(0, $charsLen - 1)];
	}
	return $result;
}

function create_password($len = 8) {
	return create_random_string($len, true, true, true, true);
}
