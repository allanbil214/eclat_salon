<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$id  = (int) ($_GET['id'] ?? 0);
$faq = $id ? get_outlet_faq($id) : null;
if ($id && !$faq) { flash('That FAQ no longer exists.', 'err'); admin_redirect('/outlets/faq?outlet_id=' . $outlet_id); }

render_admin('outlets/faq_form', [
    'title'  => ($id ? 'Edit' : 'Add') . ' FAQ — ' . $outlet['name'],
    'active' => 'outlets',
    'outlet' => $outlet,
    'faq'    => $faq,
]);
