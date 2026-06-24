<?php
declare(strict_types=1);

function get_hero_slides(): array {
    return q('SELECT * FROM hero_slides WHERE active = 1 ORDER BY sort_order ASC');
}

function get_all_hero_slides(): array {
    return q('SELECT * FROM hero_slides ORDER BY sort_order ASC, id ASC');
}

function get_hero_slide_by_id(int $id): ?array {
    return q1('SELECT * FROM hero_slides WHERE id = :id', ['id' => $id]);
}
