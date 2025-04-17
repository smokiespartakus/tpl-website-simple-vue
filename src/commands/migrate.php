<?php
/*
 * Run migrations for a sub
 */
$sub = $argv[1] ?? null;

require_once __DIR__ . '/../helpers/paths.php';
require_once helper_path('system.php');

try {
	verify_sub($sub, 'migrate');
} catch(Exception $e) {
	echo 'Error: ' . $e->getMessage() . PHP_EOL;
	exit(1);
}

define('SUB_NAME', $sub);

require_once __DIR__ . '/../base.php';

// Load env file of the specified sub to get the database connection
//env_load();
// Unsure if config is needed..
// At some point I was hoping to be able to make a prefix for tables, but doesn't seem smart
//config_load();

$folder = local_base_path('migrations');

if (!is_dir($folder)) {
	throw new Exception('Folder does not exist: ' . $folder);
}

create_migrations_table();

$migrations = arr_pluck(Db::instance()->all('SELECT * FROM _migrations WHERE util = ?', [$sub]), 'name');
$files = glob(base_path('migrations', $sub, '*.php'));
$migrCount = 0;
$queryCount = 0;
foreach($files as $file) {
	$base = basename($file);
	if (in_array($base, $migrations)) continue;
	$queries = include($file);
	dump(sprintf('Migrating %s %s', $sub, $base));
	foreach ($queries as $query) {
		Db::instance()->query($query);
		$queryCount ++;
	}
	Db::instance()->query('INSERT INTO _migrations (sub, name) VALUES (?, ?)', [$sub, $base]);
	dump(sprintf('Migrating %s %s done', $sub, $base));
	$migrCount ++;
}

if ($migrCount) dump(sprintf('Migrated %s %s files, %s queries', $migrCount, $sub, $queryCount));
else dump('Nothing to migrate...');

function create_migrations_table() {
	$sql = "CREATE TABLE IF NOT EXISTS `_migrations` (
		`id` INT(11) NOT NULL AUTO_INCREMENT,
		`sub` VARCHAR(255) NOT NULL,
		`name` VARCHAR(255) NOT NULL,
		`created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	)";
	Db::instance()->query($sql);
}
