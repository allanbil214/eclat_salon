<?php
/** Services — the full priced menu, grouped by category. */
render('services', [
    'title'  => 'Services & Pricing — ' . get_setting('site_name_full'),
    'meta'   => 'Transparent pricing for cuts, colour, treatments, bridal and men\'s grooming at ' . get_setting('site_name') . '.',
    'active' => 'services',
    'css'    => ['services'],
    'menu'   => get_menu(),
]);
