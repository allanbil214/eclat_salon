<?php
$id      = (int) ($_POST['id'] ?? 0);
$title   = trim($_POST['title'] ?? '');
$slug    = slugify($_POST['slug'] ?? '');
if ($slug === '') $slug = slugify($title);
$excerpt = trim($_POST['excerpt'] ?? '');
$body    = trim($_POST['body'] ?? '');
$cover   = trim($_POST['cover_url'] ?? '');
$author  = trim($_POST['author'] ?? '');
$category = trim($_POST['category'] ?? '');
$published = isset($_POST['is_published']) ? 1 : 0;

if ($title === '') {
    flash('A title is required.', 'err');
    admin_redirect($id ? '/articles/edit?id=' . $id : '/articles/new');
}
$slug = unique_post_slug($slug, $id);

// Set published_at the first time it goes live.
$published_at = $id ? (get_post_by_id($id)['published_at'] ?? null) : null;
if ($published && !$published_at) $published_at = date('Y-m-d H:i:s');

if ($id) {
    qexec('UPDATE posts SET title=:t, slug=:sl, excerpt=:ex, body=:bd, cover_url=:cv, author=:au, category=:cat, is_published=:pub, published_at=:pa WHERE id=:id',
        ['t'=>$title,'sl'=>$slug,'ex'=>$excerpt,'bd'=>$body,'cv'=>$cover,'au'=>$author,'cat'=>$category,'pub'=>$published,'pa'=>$published_at,'id'=>$id]);
    flash('Article updated.');
} else {
    qexec('INSERT INTO posts (title,slug,excerpt,body,cover_url,author,category,is_published,published_at) VALUES (:t,:sl,:ex,:bd,:cv,:au,:cat,:pub,:pa)',
        ['t'=>$title,'sl'=>$slug,'ex'=>$excerpt,'bd'=>$body,'cv'=>$cover,'au'=>$author,'cat'=>$category,'pub'=>$published,'pa'=>$published_at]);
    flash('Article created.');
}
admin_redirect('/articles');
