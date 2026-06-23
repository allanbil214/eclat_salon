<?php
$id = (int) ($_POST['id'] ?? 0);
if ($id) { qexec('DELETE FROM orders WHERE id = :id', ['id' => $id]); flash('Order deleted.'); }
admin_redirect('/orders');
