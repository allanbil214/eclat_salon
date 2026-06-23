<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM pages WHERE id = :id', ['id' => $id]); flash('Page deleted.'); }
admin_redirect('/pages');
