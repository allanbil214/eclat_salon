<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM posts WHERE id = :id', ['id' => $id]); flash('Article deleted.'); }
admin_redirect('/articles');
