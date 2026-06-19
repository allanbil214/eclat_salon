<?php
/** Home — the funnel. Pulls a slice of everything. */
render('home', [
    'title'  => get_setting('site_name_full') . ' — ' . get_setting('tagline'),
    'meta'   => get_setting('hero_lead'),
    'active' => 'home',
    'css'    => ['home'],
    'js'     => ['pages/gallery'],            // enables the before/after sliders
    'stats'          => get_stats(4),
    'featured'       => get_featured_services(5),
    'transformations'=> get_transformations(3),
    'team'           => get_team(4),
    'gallery'        => get_gallery(null, 6),
    'testimonials'   => get_testimonials(6),
]);
