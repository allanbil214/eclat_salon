<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM brands WHERE id = :id', ['id' => $id]); flash('Brand deleted.'); }
admin_redirect('/brands');
