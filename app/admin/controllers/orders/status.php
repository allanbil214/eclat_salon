<?php
$id = (int) ($_POST['id'] ?? 0);
$status = (string) ($_POST['status'] ?? '');
if ($id && in_array($status, order_statuses(), true)) {
    qexec('UPDATE orders SET status = :s WHERE id = :id', ['s' => $status, 'id' => $id]);
    flash('Order marked as ' . $status . '.');
} else {
    flash('Could not update the order.', 'err');
}
admin_redirect('/orders/view?id=' . $id);
