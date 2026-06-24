<?php
$id     = (int) ($_POST['id'] ?? 0);
$image  = trim($_POST['image_url'] ?? '');
$sort   = (int) ($_POST['sort_order'] ?? 0);
$active = isset($_POST['active']) ? 1 : 0;

if ($image === '') {
    flash('An image is required.', 'err');
    admin_redirect($id ? '/hero-slides/edit?id=' . $id : '/hero-slides/new');
}

if ($id) {
    qexec('UPDATE hero_slides SET image_url=:img, sort_order=:so, active=:a WHERE id=:id',
        ['img' => $image, 'so' => $sort, 'a' => $active, 'id' => $id]);
    flash('Slide updated.');
} else {
    qexec('INSERT INTO hero_slides (image_url, sort_order, active) VALUES (:img, :so, :a)',
        ['img' => $image, 'so' => $sort, 'a' => $active]);
    flash('Slide added.');
}
admin_redirect('/hero-slides');
