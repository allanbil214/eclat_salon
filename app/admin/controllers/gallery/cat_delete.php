<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM gallery_categories WHERE id = :id', ['id' => $id]); flash('Category and its photos deleted.'); }
admin_redirect('/gallery/categories');
