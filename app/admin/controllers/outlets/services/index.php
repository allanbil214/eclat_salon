<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$services = get_outlet_services($outlet_id);
render_admin('outlets/services_index', [
    'title'  => 'Services — ' . $outlet['name'],
    'active' => 'outlets',
    'outlet' => $outlet,
    'rows'   => $services,
]);
