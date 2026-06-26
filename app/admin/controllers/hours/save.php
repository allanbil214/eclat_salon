<?php
$open   = $_POST['open']   ?? [];
$close  = $_POST['close']  ?? [];
$closed = $_POST['closed'] ?? [];

// Only update main-branch rows (outlet_id IS NULL) for safety.
$hours = q('SELECT id FROM opening_hours WHERE outlet_id IS NULL');
foreach ($hours as $row) {
    $id       = (int) $row['id'];
    $isClosed = isset($closed[$id]) ? 1 : 0;
    $o        = $isClosed ? null : (trim((string) ($open[$id]  ?? '')) ?: null);
    $c        = $isClosed ? null : (trim((string) ($close[$id] ?? '')) ?: null);
    qexec('UPDATE opening_hours SET open_time = :o, close_time = :c, is_closed = :ic WHERE id = :id AND outlet_id IS NULL',
        ['o' => $o, 'c' => $c, 'ic' => $isClosed, 'id' => $id]);
}
flash('Opening hours saved.');
admin_redirect('/hours');
