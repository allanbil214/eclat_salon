<?php
/** Shop — retail products, grouped/filterable by brand. */
render('shop', [
    'title'    => 'Shop — ' . get_setting('site_name_full'),
    'meta'     => 'Salon-quality haircare to take home — the same brands we use in the chair.',
    'active'   => 'shop',
    'css'      => ['shop'],
    'js'       => ['pages/shop'],
    'products' => get_products(),
    'brands'   => get_product_brands(),
]);
