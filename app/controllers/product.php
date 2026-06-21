<?php
/** Product detail — /shop/{slug}. */
$slug    = $_GET['slug'] ?? '';
$product = get_product_by_slug($slug);

if (!$product) {
    http_response_code(404);
    require APP_PATH . '/controllers/not_found.php';
    return;
}

render('product', [
    'title'    => $product['brand'] . ' ' . $product['name'] . ' — ' . get_setting('site_name_full'),
    'meta'     => $product['description'],
    'active'   => 'shop',
    'solid_header' => true,
    'css'      => ['shop', 'product'],
    'js'       => ['pages/product'],
    'product'  => $product,
    'gallery'  => get_product_gallery($product),
    'related'  => get_related_products($product, 3),
    'wa_url'   => whatsapp_product_url($product),
]);
