<?php
/*
 * Create public symlinks for all subs
 */

echo 'Creating public symlinks for all subs' . PHP_EOL;

require_once __DIR__ . '/../helpers/paths.php';
require_once helper_path('system.php');

$subs = glob(sub_path('*'), GLOB_ONLYDIR);
if (empty($subs)) {
	echo 'No subs found' . PHP_EOL;
	exit(0);
}
$created = 0;
foreach ($subs as $sub) {
	$sub = basename($sub);
	if ($sub === '_template') continue;
	$subPublicPath = sub_path($sub, 'public');
	if (!$subPublicPath) {
		continue;
	}
	$path = public_path('_sub', $sub);
	if (is_dir($path)) {
		continue;
	}
	$exec = sprintf('./symlink %s', $sub);
	$cwd = realpath(base_path());
	$process = proc_open($exec, [], $pipes, $cwd);
	proc_close($process);
	$created++;
}

if ($created === 0) {
	echo 'No symlinks created' . PHP_EOL;
}
