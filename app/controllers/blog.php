<?php
/** Blog index — list of articles, filterable by category. */
render('blog', [
    'title'      => 'Article — ' . get_setting('site_name_full'),
    'meta'       => 'Hair tips, colour trends and transformations from the ' . get_setting('site_name') . ' team.',
    'active'     => 'blog',
    'js'         => ['pages/blog'],
    'posts'      => get_posts(),
    'categories' => get_post_categories(),
]);
