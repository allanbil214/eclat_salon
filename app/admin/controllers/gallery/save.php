<?php
$id          = (int) ($_POST['id'] ?? 0);
$category_id = (int) ($_POST['category_id'] ?? 0);
$title       = trim($_POST['title'] ?? '');
$image       = trim($_POST['image_url'] ?? '');
$before      = trim($_POST['before_image_url'] ?? '');
$stylist     = ($_POST['stylist_id'] ?? '') === '' ? null : (int) $_POST['stylist_id'];
$featured    = isset($_POST['is_featured']) ? 1 : 0;
$sort        = (int) ($_POST['sort_order'] ?? 0);

if (!$category_id || $image === '') {
    flash('A category and a main image are required.', 'err');
    admin_redirect($id ? '/gallery/edit?id=' . $id : '/gallery/new');
}
$before = $before !== '' ? $before : null;

if ($id) {
    qexec('UPDATE gallery SET category_id=:c, title=:t, image_url=:img, before_image_url=:b, stylist_id=:s, is_featured=:f, sort_order=:so WHERE id=:id',
        ['c'=>$category_id,'t'=>$title,'img'=>$image,'b'=>$before,'s'=>$stylist,'f'=>$featured,'so'=>$sort,'id'=>$id]);
    flash('Photo updated.');
} else {
    qexec('INSERT INTO gallery (category_id,title,image_url,before_image_url,stylist_id,is_featured,sort_order) VALUES (:c,:t,:img,:b,:s,:f,:so)',
        ['c'=>$category_id,'t'=>$title,'img'=>$image,'b'=>$before,'s'=>$stylist,'f'=>$featured,'so'=>$sort]);
    flash('Photo added.');
}
admin_redirect('/gallery');
