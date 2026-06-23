<?php
$id = (int) ($_GET['id'] ?? 0);
$b  = $id ? get_brand_by_id($id) : null;
if ($id && !$b) { flash('That brand no longer exists.', 'err'); admin_redirect('/brands'); }
render_admin('brands/form', ['title' => $id ? 'Edit brand' : 'New brand', 'active' => 'brands', 'b' => $b]);
