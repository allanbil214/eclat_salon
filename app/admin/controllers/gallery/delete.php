<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM gallery WHERE id = :id', ['id' => $id]); flash('Photo deleted.'); }
admin_redirect('/gallery');
