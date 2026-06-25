<?php
/** Opening hours, Monday-first. */
declare(strict_types=1);

function get_opening_hours(): array {
    return q('SELECT day_name, open_time, close_time, is_closed
              FROM opening_hours
              WHERE outlet_id IS NULL
              ORDER BY day_order ASC');
}

/**
 * All branches' hours, grouped by outlet_id. The main branch (outlet_id
 * IS NULL in the DB) is keyed as 0, so callers can do:
 *   $byOutlet[$selectedOutletId] ?? $byOutlet[0]
 */
function get_opening_hours_by_outlet(): array {
    $rows = q('SELECT outlet_id, day_name, open_time, close_time, is_closed
              FROM opening_hours ORDER BY day_order ASC');

    $byOutlet = [];
    foreach ($rows as $r) {
        $key = $r['outlet_id'] === null ? 0 : (int) $r['outlet_id'];
        $byOutlet[$key][] = [
            'day_name'   => $r['day_name'],
            'open_time'  => $r['open_time'],
            'close_time' => $r['close_time'],
            'is_closed'  => (bool) $r['is_closed'],
        ];
    }
    return $byOutlet;
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_all_opening_hours(): array {
    return q('SELECT h.id, h.outlet_id, o.name AS outlet_name,
                     h.day_order, h.day_name, h.open_time, h.close_time, h.is_closed
              FROM opening_hours h
              LEFT JOIN outlets o ON o.id = h.outlet_id
              ORDER BY COALESCE(h.outlet_id, 0) ASC, h.day_order ASC');
}