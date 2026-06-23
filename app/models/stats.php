<?php
/** Count-up numbers shown on the homepage ("16 Years", "12,000+ Guests"...). */
declare(strict_types=1);

function get_stats(int $limit = 4): array {
    return q('SELECT label, value, prefix, suffix FROM stats
              WHERE is_active = 1 ORDER BY sort_order ASC LIMIT ' . (int) $limit);
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_all_stats(): array {
    return q('SELECT * FROM stats ORDER BY sort_order ASC, id ASC');
}
function get_stat_by_id(int $id): ?array {
    return q1('SELECT * FROM stats WHERE id = :id', ['id' => $id]);
}
