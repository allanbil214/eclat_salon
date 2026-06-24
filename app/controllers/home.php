<?php
/** Home — the funnel. Pulls a slice of everything. */
render('home', [
    'title'  => get_setting('site_name_full') . ' — ' . get_setting('tagline'),
    'meta'   => get_setting('hero_lead'),
    'active' => 'home',
    'css'    => ['home'],
    'js'     => ['pages/gallery', 'pages/hero-slideshow'],
    'hero_slides'    => get_hero_slides(),
    'stats'          => get_stats(4),
    'featured'       => get_featured_services(5),
    'transformations'=> get_transformations(12),
    'team'           => get_team(4),
    'gallery'        => get_gallery(null, 6),
    'testimonials'   => get_testimonials(6),
    'shop_products'  => get_featured_products(4),
    'articles'       => get_recent_posts(3),
]);
