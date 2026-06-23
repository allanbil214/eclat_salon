<?php
$id      = (int) ($_GET['id'] ?? 0);
$product = $id ? get_product_by_id($id) : null;
if ($id && !$product) { flash('That product no longer exists.', 'err'); admin_redirect('/products'); }
render_admin('products/form', [
    'title'   => $id ? 'Edit product' : 'New product',
    'active'  => 'products',
    'quill'   => true,
    'product' => $product,
    'gallery' => $id ? get_product_images_rows($id) : [],
]);
