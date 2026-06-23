<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM team WHERE id = :id', ['id' => $id]); flash('Team member deleted.'); }
admin_redirect('/team');
