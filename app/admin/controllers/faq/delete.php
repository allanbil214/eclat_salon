<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM faq WHERE id = :id', ['id' => $id]); flash('FAQ deleted.'); }
admin_redirect('/faq');
