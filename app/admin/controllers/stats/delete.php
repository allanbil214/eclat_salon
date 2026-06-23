<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM stats WHERE id = :id', ['id' => $id]); flash('Stat deleted.'); }
admin_redirect('/stats');
