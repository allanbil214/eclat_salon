<?php
/** Admin router — handles everything under /admin. Entered from public/index.php. */
declare(strict_types=1);

define('ADMIN_PATH', APP_PATH . '/admin');
require ADMIN_PATH . '/helpers.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Sub-path within /admin: '/admin/faq' -> '/faq', '/admin' -> '/'.
$admin_path = '/' . trim(substr($path, strlen('/admin')), '/');

$admin_routes = [
    '/'           => 'dashboard',
    '/login'      => 'login',
    '/logout'     => 'logout',
    '/faq'        => 'faq/index',
    '/faq/new'    => 'faq/form',
    '/faq/edit'   => 'faq/form',
    '/faq/save'   => 'faq/save',
    '/faq/delete' => 'faq/delete',
];

// Auth guard first (except the login screen) — guests never see the admin chrome.
if ($admin_path !== '/login') {
    require_admin();
}

$action = $admin_routes[$admin_path] ?? null;
if ($action === null) {
    http_response_code(404);
    require ADMIN_PATH . '/controllers/not_found.php';
    return;
}

// CSRF on every POST.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && !csrf_verify()) {
    http_response_code(419);
    flash('Your session expired — please try again.', 'err');
    admin_redirect($admin_path === '/login' ? '/login' : '/');
}

require ADMIN_PATH . '/controllers/' . $action . '.php';
