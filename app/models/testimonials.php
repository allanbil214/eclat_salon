<?php
/** Guest reviews. */
declare(strict_types=1);

function get_testimonials(?int $limit = null): array {
    $sql = 'SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order ASC';
    if ($limit !== null) $sql .= ' LIMIT ' . (int) $limit;
    return q($sql);
}
