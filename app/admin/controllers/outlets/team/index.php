<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$all_team = get_all_team();

render_admin('outlets/team_index', [
    'title'  => 'Team — ' . $outlet['name'],
    'active' => 'outlets',
    'outlet' => $outlet,
    'team'   => $all_team,
    'js'     => ['admin-check-all'],
]);
