<?php
/**
 * OPTIONAL — build sql/eclat.sqlite from schema.sql + seed.sql so the site can
 * be previewed without a MySQL server. Not used in production.
 *   php sql/make-sqlite.php
 */
declare(strict_types=1);

$dir    = __DIR__;
$schema = file_get_contents($dir . '/schema.sql');
$seed   = file_get_contents($dir . '/seed.sql');

// Translate the MySQL dialect to SQLite (preview only).
$schema = preg_replace('/^\s*SET .*?;$/mi', '', $schema);
$schema = preg_replace('/\)\s*ENGINE=InnoDB[^;]*;/i', ');', $schema);
$schema = preg_replace('/INT\s+AUTO_INCREMENT\s+PRIMARY\s+KEY/i', 'INTEGER PRIMARY KEY AUTOINCREMENT', $schema);
$seed   = preg_replace('/^\s*SET .*?;$/mi', '', $seed);

$path = $dir . '/eclat.sqlite';
@unlink($path);

$pdo = new PDO('sqlite:' . $path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');
$pdo->exec($schema);
$pdo->exec($seed);

echo "Built " . $path . "\n";
echo "Run:  DB_DRIVER=sqlite php -S 127.0.0.1:8000 -t public public/router-dev.php\n";
