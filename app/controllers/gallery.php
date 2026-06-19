<?php
/** Gallery — filterable lookbook. */
render('gallery', [
    'title'      => 'Lookbook — ' . get_setting('site_name_full'),
    'meta'       => 'Recent colour, cuts, balayage, updos and bridal work from the ' . get_setting('site_name') . ' atelier.',
    'active'     => 'gallery',
    'css'        => ['gallery'],
    'js'         => ['pages/gallery'],
    'categories' => get_gallery_categories(),
    'items'      => get_gallery(),
]);
