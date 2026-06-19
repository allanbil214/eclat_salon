<?php
/** Lookbook images, optionally filtered by category slug. */
declare(strict_types=1);

function get_gallery_categories(): array {
    return q('SELECT id, name, slug FROM gallery_categories ORDER BY sort_order ASC');
}

function get_gallery(?string $category_slug = null, ?int $limit = null): array {
    $sql = 'SELECT g.*, c.name AS category_name, c.slug AS category_slug,
                   t.name AS stylist_name
            FROM gallery g
            JOIN gallery_categories c ON c.id = g.category_id
            LEFT JOIN team t ON t.id = g.stylist_id';
    $params = [];
    if ($category_slug !== null && $category_slug !== 'all') {
        $sql .= ' WHERE c.slug = :slug';
        $params['slug'] = $category_slug;
    }
    $sql .= ' ORDER BY g.sort_order ASC';
    if ($limit !== null) $sql .= ' LIMIT ' . (int) $limit;
    return q($sql, $params);
}

/** Featured shots that have a before/after pair, for the signature reveal. */
function get_transformations(int $limit = 3): array {
    return q("SELECT g.*, t.name AS stylist_name FROM gallery g
              LEFT JOIN team t ON t.id = g.stylist_id
              WHERE g.before_image_url IS NOT NULL AND g.before_image_url <> ''
              ORDER BY g.sort_order ASC LIMIT " . (int) $limit);
}
