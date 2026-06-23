<?php
$id          = (int) ($_POST['id'] ?? 0);
$category_id = (int) ($_POST['category_id'] ?? 0);
$name        = trim($_POST['name'] ?? '');
$desc        = trim($_POST['description'] ?? '');
$from        = trim($_POST['price_from'] ?? '');  $from = $from === '' ? null : (float) $from;
$to          = trim($_POST['price_to'] ?? '');    $to   = $to   === '' ? null : (float) $to;
$dur         = trim($_POST['duration_min'] ?? ''); $dur = $dur  === '' ? null : (int) $dur;
$featured    = isset($_POST['is_featured']) ? 1 : 0;
$active      = isset($_POST['is_active']) ? 1 : 0;
$sort        = (int) ($_POST['sort_order'] ?? 0);
if (!$category_id || $name === '') {
    flash('A category and a name are required.', 'err');
    admin_redirect($id ? '/services/edit?id=' . $id : '/services/new');
}
if ($id) {
    qexec('UPDATE services SET category_id=:c, name=:n, description=:d, price_from=:pf, price_to=:pt, duration_min=:dm, is_featured=:ft, is_active=:ia, sort_order=:so WHERE id=:id',
        ['c'=>$category_id,'n'=>$name,'d'=>$desc,'pf'=>$from,'pt'=>$to,'dm'=>$dur,'ft'=>$featured,'ia'=>$active,'so'=>$sort,'id'=>$id]);
    flash('Service updated.');
} else {
    qexec('INSERT INTO services (category_id,name,description,price_from,price_to,duration_min,is_featured,is_active,sort_order) VALUES (:c,:n,:d,:pf,:pt,:dm,:ft,:ia,:so)',
        ['c'=>$category_id,'n'=>$name,'d'=>$desc,'pf'=>$from,'pt'=>$to,'dm'=>$dur,'ft'=>$featured,'ia'=>$active,'so'=>$sort]);
    flash('Service added.');
}
admin_redirect('/services');
