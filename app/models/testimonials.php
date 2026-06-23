<?php
/** Guest reviews. */
declare(strict_types=1);

function get_testimonials(?int $limit = null): array {
    $sql = 'SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC';
    if ($limit !== null) $sql .= ' LIMIT ' . (int) $limit;
    return q($sql);
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_all_testimonials(): array {
    return q('SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC');
}
function get_testimonial_by_id(int $id): ?array {
    return q1('SELECT * FROM testimonials WHERE id = :id', ['id' => $id]);
}
