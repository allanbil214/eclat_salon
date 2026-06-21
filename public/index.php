<?php
/**
 * Front controller — every request enters here (see .htaccess).
 * Keeps routing in one tiny, readable place.
 */
declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

$routes = require APP_PATH . '/routes.php';

// Work out the requested path, stripping BASE_URL and the query string.
$uri  = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
if (BASE_URL !== '') {
    if ($uri === BASE_URL) {
        $uri = '/';
    } elseif (str_starts_with($uri, BASE_URL . '/')) {
        $uri = substr($uri, strlen(BASE_URL));
    }
}
$path = '/' . trim($uri, '/');

$controller = $routes[$path] ?? null;

// Dynamic: /shop/{slug} → product detail page.
if ($controller === null && preg_match('#^/shop/([a-z0-9][a-z0-9-]*)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    $controller = 'product';
}

// Dynamic: /blog/{slug} → article page.
if ($controller === null && preg_match('#^/blog/([a-z0-9][a-z0-9-]*)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    $controller = 'article';
}

if ($controller === null) {
    http_response_code(404);
    $controller_file = APP_PATH . '/controllers/not_found.php';
} else {
    $controller_file = APP_PATH . '/controllers/' . $controller . '.php';
}

if (!is_file($controller_file)) {
    http_response_code(404);
    $controller_file = APP_PATH . '/controllers/not_found.php';
}

require $controller_file;
