<?php
$id   = (int) ($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$slug = slugify($_POST['slug'] ?? '');
if ($slug === '') $slug = slugify($name);
$sort = (int) ($_POST['sort_order'] ?? 0);
if ($name === '') {
    flash('A category name is required.', 'err');
    admin_redirect($id ? '/gallery/categories/edit?id=' . $id : '/gallery/categories/new');
}
$slug = unique_gallery_slug($slug, $id);
if ($id) {
    qexec('UPDATE gallery_categories SET name=:n, slug=:sl, sort_order=:so WHERE id=:id', ['n'=>$name,'sl'=>$slug,'so'=>$sort,'id'=>$id]);
    flash('Category updated.');
} else {
    qexec('INSERT INTO gallery_categories (name,slug,sort_order) VALUES (:n,:sl,:so)', ['n'=>$name,'sl'=>$slug,'so'=>$sort]);
    flash('Category added.');
}
admin_redirect('/gallery/categories');
