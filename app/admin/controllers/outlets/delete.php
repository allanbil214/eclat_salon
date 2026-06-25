<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) qexec('DELETE FROM outlets WHERE id = :id', ['id' => $id]);
flash('Outlet deleted.');
admin_redirect('/outlets');
