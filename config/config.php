<?php
/**
 * ÉCLAT — Hair Atelier · configuration
 *
 * Edit the MySQL values below (or set the matching environment variables)
 * and you are done — every file reads from these constants.
 */
declare(strict_types=1);

function env(string $key, string $default = ''): string {
    $v = getenv($key);
    return ($v === false || $v === '') ? $default : $v;
}

/* ---- Paths --------------------------------------------------------------- */
define('ROOT_PATH',   dirname(__DIR__));
define('APP_PATH',    ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEWS_PATH',  APP_PATH . '/views');

/* ---- Site ---------------------------------------------------------------- */
// The subfolder the site is served from.
//   '/test'  → https://jmep.online/test/   (Hostinger shared hosting, current)
//   ''       → served at the domain root    (your own nginx, root → public/)
define('BASE_URL', env('BASE_URL', '/test'));
define('APP_TZ',   env('APP_TZ', 'Asia/Jakarta'));
define('APP_DEBUG', env('APP_DEBUG', '1') === '1');

/* ---- Database ------------------------------------------------------------ */
// 'mysql' for real use. 'sqlite' only exists so the project can be previewed
// without a MySQL server (see README → "Preview without MySQL").
define('DB_DRIVER',      env('DB_DRIVER', 'mysql'));
define('DB_HOST',        env('DB_HOST', '127.0.0.1'));
define('DB_PORT',        env('DB_PORT', '3306'));
define('DB_NAME',        env('DB_NAME', 'u180790219_eclat'));
define('DB_USER',        env('DB_USER', 'u180790219_dani'));
define('DB_PASS',        env('DB_PASS', 'Fusrodah214#'));
define('DB_SQLITE_PATH', env('DB_SQLITE_PATH', ROOT_PATH . '/sql/eclat.sqlite'));

date_default_timezone_set(APP_TZ);
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
