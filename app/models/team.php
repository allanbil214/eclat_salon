<?php
/** Stylists and the owner. */
declare(strict_types=1);

function get_team(?int $limit = null): array {
    $sql = 'SELECT * FROM team WHERE is_active = 1 ORDER BY sort_order ASC';
    if ($limit !== null) $sql .= ' LIMIT ' . (int) $limit;
    return q($sql);
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_all_team(): array {
    return q('SELECT t.*, o.name AS outlet_name
              FROM team t
              LEFT JOIN outlets o ON o.id = t.outlet_id
              ORDER BY t.sort_order ASC, t.id ASC');
}
function get_team_member_by_id(int $id): ?array {
    return q1('SELECT * FROM team WHERE id = :id', ['id' => $id]);
}
