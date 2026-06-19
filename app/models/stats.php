<?php
/** Count-up numbers shown on the homepage ("16 Years", "12,000+ Guests"...). */
declare(strict_types=1);

function get_stats(int $limit = 4): array {
    return q('SELECT label, value, prefix, suffix FROM stats
              WHERE is_active = 1 ORDER BY sort_order ASC LIMIT ' . (int) $limit);
}
