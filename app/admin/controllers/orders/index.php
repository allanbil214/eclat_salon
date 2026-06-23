<?php
$status = $_GET['status'] ?? '';
$status = in_array($status, order_statuses(), true) ? $status : null;
render_admin('orders/index', [
    'title'  => 'Orders',
    'active' => 'orders',
    'orders' => get_orders($status),
    'counts' => order_status_counts(),
    'filter' => $status,
]);
