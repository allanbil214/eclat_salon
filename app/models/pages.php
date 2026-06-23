<?php
/** Static / legal pages. */
declare(strict_types=1);

/** One active page by slug (or null). */
function get_page_by_slug(string $slug): ?array {
    return q1('SELECT * FROM pages WHERE slug = :slug AND is_active = 1', ['slug' => $slug]);
}

/* ---------------- dashboard (admin) helpers ---------------- */

/** All pages. */
function get_all_pages(): array {
    return q('SELECT * FROM pages ORDER BY id ASC');
}

/** One page by id, or null. */
function get_page_by_id(int $id): ?array {
    return q1('SELECT * FROM pages WHERE id = :id', ['id' => $id]);
}

/** Ensure a page slug is unique. */
function unique_page_slug(string $slug, int $ignore_id = 0): string {
    $slug = $slug !== '' ? $slug : 'page';
    $base = $slug; $i = 2;
    while (q1('SELECT id FROM pages WHERE slug = :s AND id <> :id', ['s' => $slug, 'id' => $ignore_id])) {
        $slug = $base . '-' . $i++;
    }
    return $slug;
}
