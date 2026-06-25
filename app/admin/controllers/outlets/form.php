<?php
$id = (int) ($_GET['id'] ?? 0);
$o  = $id ? get_outlet_by_id($id) : null;
if ($id && !$o) { flash('That outlet no longer exists.', 'err'); admin_redirect('/outlets'); }
render_admin('outlets/form', ['title' => $id ? 'Edit outlet' : 'New outlet', 'active' => 'outlets', 'o' => $o]);
