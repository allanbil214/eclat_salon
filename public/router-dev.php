<?php
/**
 * OPTIONAL — router for PHP's built-in server only (mimics .htaccess).
 *   DB_DRIVER=sqlite php -S 127.0.0.1:8000 -t public public/router-dev.php
 * Real deployments use Apache/.htaccess or the nginx config in the README.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false; // serve the real asset file as-is
}
require __DIR__ . '/index.php';
