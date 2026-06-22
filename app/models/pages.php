<?php
/** Static / legal pages. */
declare(strict_types=1);

/** One active page by slug (or null). */
function get_page_by_slug(string $slug): ?array {
    return q1('SELECT * FROM pages WHERE slug = :slug AND is_active = 1', ['slug' => $slug]);
}
