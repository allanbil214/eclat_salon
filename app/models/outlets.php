<?php
/** Outlets / Cabang — branch locations. */
declare(strict_types=1);

/* ---------- public helpers ---------- */

function get_active_outlets(?int $limit = null): array {
    $sql = 'SELECT * FROM outlets WHERE is_active = 1 ORDER BY sort_order ASC, id ASC';
    if ($limit !== null) $sql .= ' LIMIT ' . (int) $limit;
    return q($sql);
}

function get_outlet_by_slug(string $slug): ?array {
    return q1('SELECT * FROM outlets WHERE slug = :slug AND is_active = 1', ['slug' => $slug]);
}

function get_outlet_hours(int $outlet_id): array {
    return q(
        'SELECT * FROM opening_hours WHERE outlet_id = :id ORDER BY day_order ASC',
        ['id' => $outlet_id]
    );
}

function get_outlet_services_grouped(int $outlet_id): array {
    $grouped = [];
    foreach (get_outlet_services($outlet_id) as $row) {
        $grouped[$row['category_name']][] = $row;
    }
    return $grouped;
}

function get_outlet_faqs_grouped(int $outlet_id): array {
    return q(
        'SELECT * FROM outlet_faq WHERE outlet_id = :id AND is_active = 1 ORDER BY sort_order ASC, id ASC',
        ['id' => $outlet_id]
    );
}

function get_other_outlets(int $exclude_id): array {
    return q(
        'SELECT * FROM outlets WHERE is_active = 1 AND id != :id ORDER BY sort_order ASC, id ASC',
        ['id' => $exclude_id]
    );
}

/** Returns today\'s opening_hours row for an outlet, or null. */
function get_outlet_today(int $outlet_id): ?array {
    $day_order = (int) date('N'); // 1=Mon … 7=Sun
    return q1(
        'SELECT * FROM opening_hours WHERE outlet_id = :id AND day_order = :d',
        ['id' => $outlet_id, 'd' => $day_order]
    );
}

/* ---------- admin helpers ---------- */

function get_all_outlets(): array {
    return q('SELECT * FROM outlets ORDER BY sort_order ASC, id ASC');
}

function get_outlet_by_id(int $id): ?array {
    return q1('SELECT * FROM outlets WHERE id = :id', ['id' => $id]);
}

/* ---------- outlet services ---------- */

function get_outlet_services(int $outlet_id): array {
    return q('SELECT * FROM outlet_services WHERE outlet_id = :oid ORDER BY sort_order ASC, id ASC', ['oid' => $outlet_id]);
}

function get_outlet_service(int $id): ?array {
    return q1('SELECT * FROM outlet_services WHERE id = :id', ['id' => $id]);
}

/* ---------- outlet FAQs ---------- */

function get_outlet_faqs(int $outlet_id): array {
    return q('SELECT * FROM outlet_faq WHERE outlet_id = :oid ORDER BY sort_order ASC, id ASC', ['oid' => $outlet_id]);
}

function get_outlet_faq(int $id): ?array {
    return q1('SELECT * FROM outlet_faq WHERE id = :id', ['id' => $id]);
}
