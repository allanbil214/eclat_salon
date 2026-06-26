<?php
$outlet_id = (int) ($_GET['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

// Auto-seed 7 days if this outlet has no hours rows yet.
// Copies structure from the main branch (outlet_id IS NULL) so day_order/day_name stay consistent.
$hours = q('SELECT * FROM opening_hours WHERE outlet_id = :oid ORDER BY day_order ASC', ['oid' => $outlet_id]);
if (!$hours) {
    $template = q('SELECT day_order, day_name FROM opening_hours WHERE outlet_id IS NULL ORDER BY day_order ASC');
    if ($template) {
        foreach ($template as $t) {
            qexec(
                'INSERT INTO opening_hours (outlet_id, day_order, day_name, open_time, close_time, is_closed) VALUES (:oid,:do,:dn,"10:00","20:00",0)',
                ['oid' => $outlet_id, 'do' => $t['day_order'], 'dn' => $t['day_name']]
            );
        }
    } else {
        // Fallback: seed Mon–Sun manually
        $days = [['Monday',1],['Tuesday',2],['Wednesday',3],['Thursday',4],['Friday',5],['Saturday',6],['Sunday',7]];
        foreach ($days as [$dn, $do]) {
            qexec(
                'INSERT INTO opening_hours (outlet_id, day_order, day_name, open_time, close_time, is_closed) VALUES (:oid,:do,:dn,"10:00","20:00",0)',
                ['oid' => $outlet_id, 'do' => $do, 'dn' => $dn]
            );
        }
    }
    $hours = q('SELECT * FROM opening_hours WHERE outlet_id = :oid ORDER BY day_order ASC', ['oid' => $outlet_id]);
}

render_admin('outlets/hours_index', [
    'title'  => 'Opening Hours — ' . $outlet['name'],
    'active' => 'outlets',
    'outlet' => $outlet,
    'hours'  => $hours,
]);
