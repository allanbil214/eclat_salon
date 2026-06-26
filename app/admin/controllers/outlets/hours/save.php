<?php
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

$open   = $_POST['open']   ?? [];
$close  = $_POST['close']  ?? [];
$closed = $_POST['closed'] ?? [];

$hours = q('SELECT id FROM opening_hours WHERE outlet_id = :oid', ['oid' => $outlet_id]);
foreach ($hours as $row) {
    $id       = (int) $row['id'];
    $isClosed = isset($closed[$id]) ? 1 : 0;
    $o        = $isClosed ? null : (trim((string) ($open[$id]  ?? '')) ?: null);
    $c        = $isClosed ? null : (trim((string) ($close[$id] ?? '')) ?: null);
    qexec(
        'UPDATE opening_hours SET open_time = :o, close_time = :c, is_closed = :ic WHERE id = :id AND outlet_id = :oid',
        ['o' => $o, 'c' => $c, 'ic' => $isClosed, 'id' => $id, 'oid' => $outlet_id]
    );
}

flash('Opening hours saved.');
admin_redirect('/outlets/hours?outlet_id=' . $outlet_id);
