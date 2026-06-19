<?php
/** Opening hours, Monday-first. */
declare(strict_types=1);

function get_opening_hours(): array {
    return q('SELECT day_name, open_time, close_time, is_closed
              FROM opening_hours ORDER BY day_order ASC');
}
