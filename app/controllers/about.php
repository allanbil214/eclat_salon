<?php
/** About — story, values, full team. */
render('about', [
    'title'  => 'About — ' . get_setting('site_name_full'),
    'meta'   => get_setting('about_p1'),
    'active' => 'about',
    'css'    => ['about'],
    'team'   => get_team(),
    'stats'  => get_stats(4),
    'values' => [
        ['title' => 'A small room, on purpose', 'text' => 'Fewer chairs means longer appointments and undivided attention. You are never rushed and never just a number on a sheet.'],
        ['title' => 'Hair health first', 'text' => 'We will tell you when a look is not right for your hair. Healthy hair holds colour and shape better — and lasts longer between visits.'],
        ['title' => 'Trained, then trained again', 'text' => 'Every stylist trains continuously with the houses behind the products we use, so the techniques in our chairs are genuinely current.'],
    ],
]);
