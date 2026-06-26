<?php
// Bulk import selected global services into outlet_services (pre-fills name + category_name).
// Prices default to the global price_from/price_to as a starting point.
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$ids = array_map('intval', (array) ($_POST['service_ids'] ?? []));
$ids = array_filter($ids);

if (!$ids) {
    flash('No services selected.', 'err');
    admin_redirect('/outlets/services?outlet_id=' . $outlet_id);
}

// Use get_all_services() which JOINs category_name — get_service_by_id() does not.
$all = [];
foreach (get_all_services() as $g) {
    $all[$g['id']] = $g;
}

$imported = 0;
foreach ($ids as $sid) {
    $g = $all[$sid] ?? null;
    if (!$g) continue;
    qexec(
        'INSERT INTO outlet_services (outlet_id, category_name, name, price_from, price_to, sort_order, is_active) VALUES (:oid,:cn,:nm,:pf,:pt,:so,1)',
        [
            'oid' => $outlet_id,
            'cn'  => $g['category_name'],
            'nm'  => $g['name'],
            'pf'  => $g['price_from'],
            'pt'  => $g['price_to'],
            'so'  => (int) $g['sort_order'],
        ]
    );
    $imported++;
}

flash($imported . ' service(s) imported — update prices as needed.');
admin_redirect('/outlets/services?outlet_id=' . $outlet_id);
