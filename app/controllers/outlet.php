<?php
/** Single outlet detail page — /outlet/{slug}. */
$slug   = $_GET['slug'] ?? '';
$outlet = $slug ? get_outlet_by_slug($slug) : null;

if (!$outlet) {
    http_response_code(404);
    require APP_PATH . '/controllers/not_found.php';
    return;
}

render('outlet', [
    'title'       => e($outlet['name']) . ' — ' . get_setting('site_name_full'),
    'meta'        => e($outlet['address']),
    'active'      => 'outlets',
    'outlet'      => $outlet,
    'hero_slides' => get_hero_slides(),
]);
