<?php
/** Ordered — confirmation page reached only after a successful checkout. */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$order = $_SESSION['order'] ?? null;
unset($_SESSION['order']);   // one-time: refreshing won't replay it

if (!$order) {
    header('Location: ' . url('cart'));
    exit;
}

render('ordered', [
    'title'        => 'Order received — ' . get_setting('site_name_full'),
    'meta'         => 'Your order has been received.',
    'active'       => 'shop',
    'solid_header' => true,
    'css'          => ['cart', 'booked'],
    'js'           => ['pages/booked'],   // reuse the countdown → open WhatsApp
    'ref'          => $order['ref'],
    'name'         => $order['name'],
    'total'        => $order['total'],
    'items'        => $order['items'],
    'wa_url'       => $order['wa_url'],
]);
