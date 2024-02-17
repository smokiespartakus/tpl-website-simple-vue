<?php

/**
 * @param array $arr
 * @param $key
 * @param null $default
 * @return array|mixed|null
 */
function arr_get($arr, $key, $default = null) {
	$value = $arr;
	if ($key === null) return $value;
	$keys = explode('.', $key);
	while (($k = array_shift($keys)) !== null) {
		if (!is_array($value)) return $default;
		if (!isset($value[$k])) return $default;
		$value = $value[$k];
	}
	return $value;
}

function arr_pluck(array $arr, $keyString) {
	return array_map(function($item) use ($keyString) {
		return $item[$keyString];
	}, $arr);
}
