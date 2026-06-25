<?php
/** Outlets listing page. */
$hero_slides = get_hero_slides();
render('outlets', [
    'title'       => 'Our Locations — ' . get_setting('site_name_full'),
    'meta'        => 'Find an ÉCLAT salon near you across Jabodetabek.',
    'active'      => 'outlets',
    'outlets'     => get_active_outlets(),
    'hero_slides' => $hero_slides,
]);
