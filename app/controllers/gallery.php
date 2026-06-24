<?php
/** Gallery — filterable lookbook. */
render('gallery', [
    'title'      => 'Lookbook — ' . get_setting('site_name_full'),
    'meta'       => 'Recent colour, cuts, balayage, updos and bridal work from the ' . get_setting('site_name') . ' atelier.',
    'active'     => 'gallery',
    'css'        => ['gallery', 'lightbox'],
    'js'         => ['pages/gallery', 'pages/lightbox'],
    'categories' => get_gallery_categories(),
    'items'      => get_gallery(),
]);
