<?php
$id  = (int) ($_GET['id'] ?? 0);
$cat = $id ? get_gallery_category_by_id($id) : null;
if ($id && !$cat) { flash('That category no longer exists.', 'err'); admin_redirect('/gallery/categories'); }
render_admin('gallery/cat_form', ['title' => $id ? 'Edit category' : 'New category', 'active' => 'gallery', 'cat' => $cat]);
