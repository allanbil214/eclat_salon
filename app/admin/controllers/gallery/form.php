<?php
$id   = (int) ($_GET['id'] ?? 0);
$item = $id ? get_gallery_item_by_id($id) : null;
if ($id && !$item) { flash('That photo no longer exists.', 'err'); admin_redirect('/gallery'); }
$cats = get_gallery_categories();
if (!$cats) { flash('Create a gallery category first, then add photos.', 'err'); admin_redirect('/gallery/categories'); }
render_admin('gallery/form', [
    'title'  => $id ? 'Edit photo' : 'New photo',
    'active' => 'gallery',
    'item'   => $item,
    'cats'   => $cats,
    'team'   => get_team(),
]);
