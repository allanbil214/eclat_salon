<?php
$id   = (int) ($_GET['id'] ?? 0);
$post = $id ? get_post_by_id($id) : null;
if ($id && !$post) { flash('That article no longer exists.', 'err'); admin_redirect('/articles'); }
render_admin('articles/form', [
    'title'      => $id ? 'Edit article' : 'New article',
    'active'     => 'articles',
    'quill'      => true,
    'post'       => $post,
    'categories' => get_post_categories(),
]);
