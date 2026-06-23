<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM products WHERE id = :id', ['id' => $id]); flash('Product deleted.'); }
admin_redirect('/products');
