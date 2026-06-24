<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM hero_slides WHERE id = :id', ['id' => $id]); flash('Slide deleted.'); }
admin_redirect('/hero-slides');
