<?php
$id    = (int) ($_POST['id'] ?? 0);
$name  = trim($_POST['name'] ?? '');
$slug  = slugify($_POST['slug'] ?? '');
if ($slug === '') $slug = slugify($name);
$blurb = trim($_POST['blurb'] ?? '');
$sort  = (int) ($_POST['sort_order'] ?? 0);
if ($name === '') { flash('A name is required.', 'err'); admin_redirect($id ? '/services/categories/edit?id=' . $id : '/services/categories/new'); }
$slug = unique_service_slug($slug, $id);
if ($id) {
    qexec('UPDATE service_categories SET name=:n, slug=:sl, blurb=:b, sort_order=:so WHERE id=:id', ['n'=>$name,'sl'=>$slug,'b'=>$blurb,'so'=>$sort,'id'=>$id]);
    flash('Category updated.');
} else {
    qexec('INSERT INTO service_categories (name,slug,blurb,sort_order) VALUES (:n,:sl,:b,:so)', ['n'=>$name,'sl'=>$slug,'b'=>$blurb,'so'=>$sort]);
    flash('Category added.');
}
admin_redirect('/services/categories');
