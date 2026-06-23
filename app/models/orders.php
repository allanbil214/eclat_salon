<?php
/** Shop orders placed through the cart. */
declare(strict_types=1);

/**
 * Save an order and its line items inside a transaction.
 * $customer: name, phone, email, address, fulfillment, note
 * $items:    list of [product_id, product_name, brand, unit_price, qty, line_total]
 * Returns ['id' => int, 'ref' => string].
 */
function create_order(array $customer, array $items, float $total): array {
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO orders
                (ref, customer_name, customer_phone, customer_email, address,
                 fulfillment, note, item_count, total, status, created_at)
             VALUES (:ref, :name, :phone, :email, :address,
                 :fulfillment, :note, :item_count, :total, :status, :created_at)'
        );
        $item_count = array_sum(array_column($items, 'qty'));
        $stmt->execute([
            'ref'         => '',
            'name'        => $customer['name'],
            'phone'       => $customer['phone'],
            'email'       => $customer['email'],
            'address'     => $customer['address'],
            'fulfillment' => $customer['fulfillment'] === 'delivery' ? 'delivery' : 'pickup',
            'note'        => $customer['note'],
            'item_count'  => $item_count,
            'total'       => $total,
            'status'      => 'new',
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
        $id  = (int) $pdo->lastInsertId();
        $ref = 'ECL-' . str_pad((string) $id, 4, '0', STR_PAD_LEFT);
        $pdo->prepare('UPDATE orders SET ref = :ref WHERE id = :id')
            ->execute(['ref' => $ref, 'id' => $id]);

        $line = $pdo->prepare(
            'INSERT INTO order_items
                (order_id, product_id, product_name, brand, unit_price, qty, line_total)
             VALUES (:order_id, :product_id, :product_name, :brand, :unit_price, :qty, :line_total)'
        );
        foreach ($items as $it) {
            $line->execute([
                'order_id'     => $id,
                'product_id'   => $it['product_id'],
                'product_name' => $it['product_name'],
                'brand'        => $it['brand'],
                'unit_price'   => $it['unit_price'],
                'qty'          => $it['qty'],
                'line_total'   => $it['line_total'],
            ]);
        }
        $pdo->commit();
        return ['id' => $id, 'ref' => $ref];
    } catch (\Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

/** Build a wa.me link with the whole order pre-filled (Indonesian). */
function whatsapp_order_url(string $ref, array $customer, array $items, float $total): string {
    $number = preg_replace('/\D+/', '', get_setting('whatsapp'));
    if ($number === '') {
        return '';
    }
    $lines = ['Halo ÉCLAT! Saya ingin memesan: (Ref: ' . $ref . ')', ''];
    foreach ($items as $it) {
        $lines[] = '• ' . trim($it['brand'] . ' ' . $it['product_name'])
            . ' ×' . $it['qty'] . ' — ' . money((float) $it['line_total']);
    }
    $lines[] = '';
    $lines[] = '*Total: ' . money($total) . '*';
    $lines[] = '';
    $lines[] = 'Nama: '   . ($customer['name']  !== '' ? $customer['name']  : '-');
    $lines[] = 'No. HP: ' . ($customer['phone'] !== '' ? $customer['phone'] : '-');
    if ($customer['email'] !== '') {
        $lines[] = 'Email: ' . $customer['email'];
    }
    $lines[] = 'Pengambilan: ' . ($customer['fulfillment'] === 'delivery' ? 'Diantar' : 'Ambil di salon');
    if ($customer['fulfillment'] === 'delivery' || $customer['address'] !== '') {
        $lines[] = 'Alamat: ' . ($customer['address'] !== '' ? $customer['address'] : '-');
    }
    if ($customer['note'] !== '') {
        $lines[] = 'Catatan: ' . $customer['note'];
    }
    return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
}

/* ---------------- dashboard (admin) helpers ---------------- */

/** Allowed order statuses, in workflow order. */
function order_statuses(): array {
    return ['new', 'contacted', 'completed'];
}

/** Orders newest first, optionally filtered by status. */
function get_orders(?string $status = null): array {
    if ($status !== null && in_array($status, order_statuses(), true)) {
        return q('SELECT * FROM orders WHERE status = :s ORDER BY created_at DESC, id DESC', ['s' => $status]);
    }
    return q('SELECT * FROM orders ORDER BY created_at DESC, id DESC');
}

/** A single order, or null. */
function get_order(int $id): ?array {
    return q1('SELECT * FROM orders WHERE id = :id', ['id' => $id]);
}

/** Line items for an order. */
function get_order_items(int $order_id): array {
    return q('SELECT * FROM order_items WHERE order_id = :id ORDER BY id ASC', ['id' => $order_id]);
}

/** Count of orders per status (plus 'all') for filter tabs. */
function order_status_counts(): array {
    $counts = ['all' => 0];
    foreach (order_statuses() as $s) $counts[$s] = 0;
    foreach (q('SELECT status, COUNT(*) c FROM orders GROUP BY status') as $row) {
        $counts['all'] += (int) $row['c'];
        $counts[$row['status']] = (int) $row['c'];
    }
    return $counts;
}

/** Normalise an Indonesian phone number for wa.me (0… -> 62…). */
function wa_number(string $raw): string {
    $n = preg_replace('/\D+/', '', $raw) ?? '';
    if ($n === '') return '';
    if (str_starts_with($n, '0'))  return '62' . substr($n, 1);
    if (str_starts_with($n, '62')) return $n;
    if (str_starts_with($n, '8'))  return '62' . $n;
    return $n;
}

/** wa.me link that messages the CUSTOMER about their order (Indonesian). */
function whatsapp_customer_url(array $order): string {
    $number = wa_number((string) ($order['customer_phone'] ?? ''));
    if ($number === '') return '';
    $name = trim((string) $order['customer_name']);
    $lines = [
        'Halo ' . ($name !== '' ? $name : 'Kak') . '! Terima kasih atas pesanan Anda di ÉCLAT.',
        'Ref pesanan: ' . $order['ref'],
        'Total: ' . money((float) $order['total']),
        '',
        'Kami ingin mengonfirmasi pesanan Anda. ',
    ];
    return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
}
