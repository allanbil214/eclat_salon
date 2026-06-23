<?php
$id = (int) ($_GET['id'] ?? 0);
$order = $id ? get_order($id) : null;
if (!$order) { flash('That order no longer exists.', 'err'); admin_redirect('/orders'); }
render_admin('orders/view', [
    'title'  => 'Order ' . $order['ref'],
    'active' => 'orders',
    'order'  => $order,
    'items'  => get_order_items($id),
]);
