<?php
$id       = (int) ($_POST['id'] ?? 0);
$name     = trim($_POST['name'] ?? '');
$slug     = trim($_POST['slug'] ?? '');
$city     = trim($_POST['city'] ?? '');
$address  = trim($_POST['address'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$whatsapp = trim($_POST['whatsapp'] ?? '');
$gmaps    = trim($_POST['gmaps_url'] ?? '');
$photo    = trim($_POST['photo_url'] ?? '');
$active   = isset($_POST['is_active']) ? 1 : 0;
$sort     = (int) ($_POST['sort_order'] ?? 0);

// Auto-slug if blank
if ($slug === '' && $name !== '') {
    $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    $slug = trim($slug, '-');
}

if ($name === '') {
    flash('A name is required.', 'err');
    admin_redirect($id ? '/outlets/edit?id=' . $id : '/outlets/new');
}

if ($id) {
    qexec('UPDATE outlets SET name=:nm, slug=:sl, city=:ct, address=:ad, phone=:ph, whatsapp=:wa, gmaps_url=:gm, photo_url=:pu, is_active=:ia, sort_order=:so WHERE id=:id',
        ['nm'=>$name,'sl'=>$slug,'ct'=>$city,'ad'=>$address,'ph'=>$phone,'wa'=>$whatsapp,'gm'=>$gmaps,'pu'=>$photo,'ia'=>$active,'so'=>$sort,'id'=>$id]);
    flash('Outlet updated.');
} else {
    qexec('INSERT INTO outlets (name,slug,city,address,phone,whatsapp,gmaps_url,photo_url,is_active,sort_order) VALUES (:nm,:sl,:ct,:ad,:ph,:wa,:gm,:pu,:ia,:so)',
        ['nm'=>$name,'sl'=>$slug,'ct'=>$city,'ad'=>$address,'ph'=>$phone,'wa'=>$whatsapp,'gm'=>$gmaps,'pu'=>$photo,'ia'=>$active,'so'=>$sort]);
    flash('Outlet added.');
}
admin_redirect('/outlets');
