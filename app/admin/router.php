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
    '/'              => 'dashboard',
    '/login'         => 'login',
    '/logout'        => 'logout',
    '/upload'        => 'upload',
    '/faq'           => 'faq/index',
    '/faq/new'       => 'faq/form',
    '/faq/edit'      => 'faq/form',
    '/faq/save'      => 'faq/save',
    '/faq/delete'    => 'faq/delete',
    '/products'        => 'products/index',
    '/products/new'    => 'products/form',
    '/products/edit'   => 'products/form',
    '/products/save'   => 'products/save',
    '/products/delete' => 'products/delete',
    '/orders'        => 'orders/index',
    '/orders/view'   => 'orders/view',
    '/orders/status' => 'orders/status',
    '/orders/delete' => 'orders/delete',
    '/articles'        => 'articles/index',
    '/articles/new'    => 'articles/form',
    '/articles/edit'   => 'articles/form',
    '/articles/save'   => 'articles/save',
    '/articles/delete' => 'articles/delete',
    '/pages'        => 'pages/index',
    '/pages/new'    => 'pages/form',
    '/pages/edit'   => 'pages/form',
    '/pages/save'   => 'pages/save',
    '/pages/delete' => 'pages/delete',
    '/hero-slides'        => 'hero_slides/index',
    '/hero-slides/new'    => 'hero_slides/form',
    '/hero-slides/edit'   => 'hero_slides/form',
    '/hero-slides/save'   => 'hero_slides/save',
    '/hero-slides/delete' => 'hero_slides/delete',
    '/gallery'        => 'gallery/index',
    '/gallery/new'    => 'gallery/form',
    '/gallery/edit'   => 'gallery/form',
    '/gallery/save'   => 'gallery/save',
    '/gallery/delete' => 'gallery/delete',
    '/gallery/categories'        => 'gallery/cats_index',
    '/gallery/categories/new'    => 'gallery/cat_form',
    '/gallery/categories/edit'   => 'gallery/cat_form',
    '/gallery/categories/save'   => 'gallery/cat_save',
    '/gallery/categories/delete' => 'gallery/cat_delete',
    '/testimonials'        => 'testimonials/index',
    '/testimonials/new'    => 'testimonials/form',
    '/testimonials/edit'   => 'testimonials/form',
    '/testimonials/save'   => 'testimonials/save',
    '/testimonials/delete' => 'testimonials/delete',
    '/brands'        => 'brands/index',
    '/brands/new'    => 'brands/form',
    '/brands/edit'   => 'brands/form',
    '/brands/save'   => 'brands/save',
    '/brands/delete' => 'brands/delete',
    '/settings'      => 'settings/index',
    '/settings/save' => 'settings/save',
    '/hours'         => 'hours/index',
    '/hours/save'    => 'hours/save',
    '/stats'         => 'stats/index',
    '/stats/new'     => 'stats/form',
    '/stats/edit'    => 'stats/form',
    '/stats/save'    => 'stats/save',
    '/stats/delete'  => 'stats/delete',
    '/services'        => 'services/index',
    '/services/new'    => 'services/form',
    '/services/edit'   => 'services/form',
    '/services/save'   => 'services/save',
    '/services/delete' => 'services/delete',
    '/services/categories'        => 'services/cats_index',
    '/services/categories/new'    => 'services/cat_form',
    '/services/categories/edit'   => 'services/cat_form',
    '/services/categories/save'   => 'services/cat_save',
    '/services/categories/delete' => 'services/cat_delete',
    '/team'        => 'team/index',
    '/team/new'    => 'team/form',
    '/team/edit'   => 'team/form',
    '/team/save'   => 'team/save',
    '/team/delete' => 'team/delete',
    '/bookings'        => 'bookings/index',
    '/bookings/view'   => 'bookings/view',
    '/bookings/delete' => 'bookings/delete',
    '/outlets'                      => 'outlets/index',
    '/outlets/new'                  => 'outlets/form',
    '/outlets/edit'                 => 'outlets/form',
    '/outlets/save'                 => 'outlets/save',
    '/outlets/delete'               => 'outlets/delete',
    '/outlets/services'             => 'outlets/services/index',
    '/outlets/services/new'         => 'outlets/services/form',
    '/outlets/services/edit'        => 'outlets/services/form',
    '/outlets/services/save'        => 'outlets/services/save',
    '/outlets/services/delete'      => 'outlets/services/delete',
    '/outlets/services/import'      => 'outlets/services/import',
    '/outlets/faq'                  => 'outlets/faq/index',
    '/outlets/faq/new'              => 'outlets/faq/form',
    '/outlets/faq/edit'             => 'outlets/faq/form',
    '/outlets/faq/save'             => 'outlets/faq/save',
    '/outlets/faq/delete'           => 'outlets/faq/delete',
    '/outlets/hours'                => 'outlets/hours/index',
    '/outlets/hours/save'           => 'outlets/hours/save',
    '/outlets/team'                 => 'outlets/team/index',
    '/outlets/team/save'            => 'outlets/team/save',
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
