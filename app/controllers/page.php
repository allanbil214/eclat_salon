<?php
/** Static page — /{slug} (e.g. /privacy, /terms). */
$slug = $_GET['slug'] ?? '';
$page = get_page_by_slug($slug);

if (!$page) {
    http_response_code(404);
    require APP_PATH . '/controllers/not_found.php';
    return;
}

render('page', [
    'title'        => $page['title'] . ' — ' . get_setting('site_name_full'),
    'meta'         => $page['title'] . ' — ' . get_setting('site_name'),
    'active'       => '',
    'css'          => ['page'],
    'page'         => $page,
]);
