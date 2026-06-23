<?php
$id     = (int) ($_POST['id'] ?? 0);
$title  = trim($_POST['title'] ?? '');
$slug   = slugify($_POST['slug'] ?? '');
if ($slug === '') $slug = slugify($title);
$body   = trim($_POST['body'] ?? '');
$active = isset($_POST['is_active']) ? 1 : 0;

if ($title === '') {
    flash('A title is required.', 'err');
    admin_redirect($id ? '/pages/edit?id=' . $id : '/pages/new');
}
$slug = unique_page_slug($slug, $id);
$now  = date('Y-m-d H:i:s');

if ($id) {
    qexec('UPDATE pages SET slug=:sl, title=:t, body=:bd, is_active=:ia, updated_at=:ua WHERE id=:id',
        ['sl'=>$slug,'t'=>$title,'bd'=>$body,'ia'=>$active,'ua'=>$now,'id'=>$id]);
    flash('Page updated.');
} else {
    qexec('INSERT INTO pages (slug,title,body,is_active,updated_at) VALUES (:sl,:t,:bd,:ia,:ua)',
        ['sl'=>$slug,'t'=>$title,'bd'=>$body,'ia'=>$active,'ua'=>$now]);
    flash('Page created.');
}
admin_redirect('/pages');
