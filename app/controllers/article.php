<?php
/** Article — /blog/{slug}. */
$slug = $_GET['slug'] ?? '';
$post = get_post_by_slug($slug);

if (!$post) {
    http_response_code(404);
    require APP_PATH . '/controllers/not_found.php';
    return;
}

render('article', [
    'title'        => $post['title'] . ' — ' . get_setting('site_name_full'),
    'meta'         => $post['excerpt'] !== '' ? $post['excerpt'] : $post['title'],
    'active'       => 'blog',
    'css'          => ['article'],
    'post'         => $post,
    'more'         => get_recent_posts(3, (int) $post['id']),
]);
