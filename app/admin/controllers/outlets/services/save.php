<?php
$outlet_id    = (int) ($_POST['outlet_id'] ?? 0);
$outlet       = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$id           = (int) ($_POST['id'] ?? 0);
$category_name = trim($_POST['category_name'] ?? '');
$name          = trim($_POST['name'] ?? '');
$price_from    = $_POST['price_from'] !== '' ? (float) $_POST['price_from'] : null;
$price_to      = $_POST['price_to']   !== '' ? (float) $_POST['price_to']   : null;
$sort          = (int) ($_POST['sort_order'] ?? 0);
$active        = isset($_POST['is_active']) ? 1 : 0;

if ($name === '') {
    flash('Service name is required.', 'err');
    $back = '/outlets/services/edit?outlet_id=' . $outlet_id . ($id ? '&id=' . $id : '');
    admin_redirect($back);
}

if ($id) {
    qexec(
        'UPDATE outlet_services SET category_name=:cn, name=:nm, price_from=:pf, price_to=:pt, sort_order=:so, is_active=:ia WHERE id=:id AND outlet_id=:oid',
        ['cn'=>$category_name,'nm'=>$name,'pf'=>$price_from,'pt'=>$price_to,'so'=>$sort,'ia'=>$active,'id'=>$id,'oid'=>$outlet_id]
    );
    flash('Service updated.');
} else {
    qexec(
        'INSERT INTO outlet_services (outlet_id, category_name, name, price_from, price_to, sort_order, is_active) VALUES (:oid,:cn,:nm,:pf,:pt,:so,:ia)',
        ['oid'=>$outlet_id,'cn'=>$category_name,'nm'=>$name,'pf'=>$price_from,'pt'=>$price_to,'so'=>$sort,'ia'=>$active]
    );
    flash('Service added.');
}
admin_redirect('/outlets/services?outlet_id=' . $outlet_id);
