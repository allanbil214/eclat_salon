<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM service_categories WHERE id = :id', ['id' => $id]); flash('Category and its services deleted.'); }
admin_redirect('/services/categories');
