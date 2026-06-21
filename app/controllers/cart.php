<?php
/** Cart — shows the cart + checkout form, and processes the order on POST. */
$errors = [];
$old = [
    'name' => '', 'phone' => '', 'email' => '',
    'address' => '', 'fulfillment' => 'pickup', 'note' => '',
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Honeypot: real users leave this empty.
    if (trim($_POST['website'] ?? '') !== '') {
        header('Location: ' . url(''));
        exit;
    }

    foreach ($old as $k => $_) {
        $old[$k] = trim((string) ($_POST[$k] ?? ''));
    }
    $old['fulfillment'] = $old['fulfillment'] === 'delivery' ? 'delivery' : 'pickup';

    // The cart travels as JSON in a hidden field (it lives in the browser).
    $cart = json_decode((string) ($_POST['cart_json'] ?? '[]'), true);
    if (!is_array($cart)) {
        $cart = [];
    }

    // Re-price every line from the database — never trust the client's prices.
    $items = [];
    $total = 0.0;
    foreach ($cart as $row) {
        $id  = (int) ($row['id'] ?? 0);
        $qty = max(1, min(99, (int) ($row['qty'] ?? 1)));
        if ($id <= 0) {
            continue;
        }
        $p = q1('SELECT * FROM products WHERE id = :id', ['id' => $id]);
        if (!$p || !(int) $p['in_stock']) {
            continue;   // skip removed or out-of-stock products
        }
        $unit = (float) $p['price'];
        $line = $unit * $qty;
        $total += $line;
        $items[] = [
            'product_id'   => $id,
            'product_name' => $p['name'],
            'brand'        => $p['brand'],
            'unit_price'   => $unit,
            'qty'          => $qty,
            'line_total'   => $line,
        ];
    }

    if (!$items) {
        $errors['cart'] = 'Your cart is empty — add a product before ordering.';
    }
    if ($old['name'] === '') {
        $errors['name'] = 'Please tell us your name.';
    }
    if ($old['phone'] === '') {
        $errors['phone'] = 'A phone number lets us reach you.';
    }
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'That email address looks off.';
    }
    if ($old['fulfillment'] === 'delivery' && $old['address'] === '') {
        $errors['address'] = 'We need an address to deliver to.';
    }

    if (!$errors) {
        $order = create_order($old, $items, $total);
        $wa    = whatsapp_order_url($order['ref'], $old, $items, $total);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION['order'] = [
            'ref'    => $order['ref'],
            'name'   => $old['name'],
            'total'  => $total,
            'items'  => $items,
            'wa_url' => $wa,
        ];
        header('Location: ' . url('ordered'));
        exit;
    }
}

render('cart', [
    'title'        => 'Your cart — ' . get_setting('site_name_full'),
    'meta'         => 'Review your products and place your order.',
    'active'       => 'shop',
    'solid_header' => true,
    'css'          => ['cart'],
    'errors'       => $errors,
    'old'          => $old,
]);
