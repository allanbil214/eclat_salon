<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$id  = (int) ($_GET['id'] ?? 0);
$svc = $id ? get_outlet_service($id) : null;
if ($id && !$svc) { flash('That service no longer exists.', 'err'); admin_redirect('/outlets/services?outlet_id=' . $outlet_id); }

// Global services for the import modal (grouped by category)
$global_services = get_all_services();

render_admin('outlets/services_form', [
    'title'           => ($id ? 'Edit' : 'Add') . ' service — ' . $outlet['name'],
    'active'          => 'outlets',
    'outlet'          => $outlet,
    'svc'             => $svc,
    'global_services' => $global_services,
]);
