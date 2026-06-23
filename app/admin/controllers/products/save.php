<?php
$id    = (int) ($_POST['id'] ?? 0);
$name  = trim($_POST['name'] ?? '');
$brand = trim($_POST['brand'] ?? '');
$slug  = slugify($_POST['slug'] ?? '');
if ($slug === '') $slug = slugify($name);
$description = trim($_POST['description'] ?? '');
$priceRaw = trim($_POST['price'] ?? '');
$price = $priceRaw === '' ? null : (float) $priceRaw;
$image = trim($_POST['image_url'] ?? '');
$stock = isset($_POST['in_stock']) ? 1 : 0;
$sort  = (int) ($_POST['sort_order'] ?? 0);
$gallery = $_POST['gallery'] ?? [];

if ($name === '') {
    flash('A product name is required.', 'err');
    admin_redirect($id ? '/products/edit?id=' . $id : '/products/new');
}
$slug = unique_product_slug($slug, $id);

if ($id) {
    qexec('UPDATE products SET name=:n, slug=:sl, brand=:b, description=:d, price=:p, image_url=:img, in_stock=:st, sort_order=:so WHERE id=:id',
        ['n'=>$name,'sl'=>$slug,'b'=>$brand,'d'=>$description,'p'=>$price,'img'=>$image,'st'=>$stock,'so'=>$sort,'id'=>$id]);
    flash('Product updated.');
} else {
    qexec('INSERT INTO products (name,slug,brand,description,price,image_url,in_stock,sort_order) VALUES (:n,:sl,:b,:d,:p,:img,:st,:so)',
        ['n'=>$name,'sl'=>$slug,'b'=>$brand,'d'=>$description,'p'=>$price,'img'=>$image,'st'=>$stock,'so'=>$sort]);
    $id = (int) db()->lastInsertId();
    flash('Product added.');
}

// Rebuild the gallery from the submitted order.
qexec('DELETE FROM product_images WHERE product_id = :id', ['id' => $id]);
$so = 1;
foreach ((array) $gallery as $url) {
    $url = trim((string) $url);
    if ($url === '') continue;
    qexec('INSERT INTO product_images (product_id, image_url, sort_order) VALUES (:pid,:u,:so)',
        ['pid'=>$id,'u'=>$url,'so'=>$so++]);
}
admin_redirect('/products');
