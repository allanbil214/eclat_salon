<?php
/** Product brands used in the salon (the marquee). */
declare(strict_types=1);

function get_brands(): array {
    return q('SELECT * FROM brands ORDER BY sort_order ASC, id ASC');
}

/* ---------------- dashboard (admin) helpers ---------------- */
function get_all_brands(): array {
    return q('SELECT * FROM brands ORDER BY sort_order ASC, id ASC');
}
function get_brand_by_id(int $id): ?array {
    return q1('SELECT * FROM brands WHERE id = :id', ['id' => $id]);
}
