<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM services WHERE id = :id', ['id' => $id]); flash('Service deleted.'); }
admin_redirect('/services');
