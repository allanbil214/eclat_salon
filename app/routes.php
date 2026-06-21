<?php
/**
 * Route map: a clean URL path → the controller file that handles it.
 * Add a page by adding a line here and a file in app/controllers.
 */
declare(strict_types=1);

return [
    '/'         => 'home',
    '/about'    => 'about',
    '/services' => 'services',
    '/gallery'  => 'gallery',
    '/shop'     => 'shop',
    '/cart'     => 'cart',
    '/ordered'  => 'ordered',
    '/book'     => 'book',
    '/booked'   => 'booked',
];
