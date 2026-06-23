<?php
$id  = (int) ($_GET['id'] ?? 0);
$cat = $id ? get_service_category_by_id($id) : null;
if ($id && !$cat) { flash('That category no longer exists.', 'err'); admin_redirect('/services/categories'); }
render_admin('services/cat_form', ['title' => $id ? 'Edit category' : 'New category', 'active' => 'services', 'cat' => $cat]);
