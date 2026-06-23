<?php
$open = $_POST['open'] ?? []; $close = $_POST['close'] ?? []; $closed = $_POST['closed'] ?? [];
foreach (get_all_opening_hours() as $row) {
    $id = (int) $row['id'];
    $isClosed = isset($closed[$id]) ? 1 : 0;
    $o = $isClosed ? null : (trim((string) ($open[$id]  ?? '')) ?: null);
    $c = $isClosed ? null : (trim((string) ($close[$id] ?? '')) ?: null);
    qexec('UPDATE opening_hours SET open_time = :o, close_time = :c, is_closed = :ic WHERE id = :id',
        ['o' => $o, 'c' => $c, 'ic' => $isClosed, 'id' => $id]);
}
flash('Opening hours saved.');
admin_redirect('/hours');
