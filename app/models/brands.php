<?php
/** Product brands used in the salon (the marquee). */
declare(strict_types=1);

function get_brands(): array {
    return q('SELECT name FROM brands ORDER BY sort_order ASC');
}
