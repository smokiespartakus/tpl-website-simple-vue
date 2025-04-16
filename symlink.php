<?php
/*
 * Create public symling for a sub
 */
$sub = $argv[1] ?? null;

if (!$sub) {
	throw new Exception('No sub specified (1st argument)');
}
define('SUB_NAME', $sub);

require_once __DIR__ . '/base.php';
$fromPath = realpath(local_public_path());
if(!is_dir($fromPath)) {
	echo 'Error: public folder does not exist' . PHP_EOL;
	exit(1);
}
$toPath = path_combine(realpath(public_path('_sub')), $sub);

echo 'Creating symlink for ' . $fromPath . PHP_EOL;
$command = 'ln -s ' . $fromPath . ' ' . $toPath;
//echo $command . PHP_EOL;
exec($command, $output, $return_var);
if ($return_var !== 0) {
	echo 'Error creating symlink' . PHP_EOL;
	print_r($output);
	exit(1);
}
echo 'Symlink created' . PHP_EOL;
