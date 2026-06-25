<?php
$id        = (int) ($_POST['id'] ?? 0);
$name      = trim($_POST['name'] ?? '');
$role      = trim($_POST['role'] ?? '');
$specialty = trim($_POST['specialty'] ?? '');
$bio       = trim($_POST['bio'] ?? '');
$photo     = trim($_POST['photo_url'] ?? '');
$instagram = trim($_POST['instagram'] ?? '');
$years     = trim($_POST['years_exp'] ?? ''); $years = $years === '' ? null : (int) $years;
$owner     = isset($_POST['is_owner']) ? 1 : 0;
$active    = isset($_POST['is_active']) ? 1 : 0;
$sort      = (int) ($_POST['sort_order'] ?? 0);
$outlet_id = trim($_POST['outlet_id'] ?? ''); $outlet_id = $outlet_id !== '' ? (int) $outlet_id : null;
if ($name === '' || $role === '') {
    flash('Name and role are required.', 'err');
    admin_redirect($id ? '/team/edit?id=' . $id : '/team/new');
}
if ($id) {
    qexec('UPDATE team SET name=:n, role=:r, specialty=:sp, bio=:b, photo_url=:ph, instagram=:ig, years_exp=:y, is_owner=:ow, is_active=:ia, sort_order=:so, outlet_id=:oi WHERE id=:id',
        ['n'=>$name,'r'=>$role,'sp'=>$specialty,'b'=>$bio,'ph'=>$photo,'ig'=>$instagram,'y'=>$years,'ow'=>$owner,'ia'=>$active,'so'=>$sort,'oi'=>$outlet_id,'id'=>$id]);
    flash('Team member updated.');
} else {
    qexec('INSERT INTO team (name,role,specialty,bio,photo_url,instagram,years_exp,is_owner,is_active,sort_order,outlet_id) VALUES (:n,:r,:sp,:b,:ph,:ig,:y,:ow,:ia,:so,:oi)',
        ['n'=>$name,'r'=>$role,'sp'=>$specialty,'b'=>$bio,'ph'=>$photo,'ig'=>$instagram,'y'=>$years,'ow'=>$owner,'ia'=>$active,'so'=>$sort,'oi'=>$outlet_id]);
    flash('Team member added.');
}
admin_redirect('/team');
