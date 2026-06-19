<?php
/** Service menu: categories and the items within them. */
declare(strict_types=1);

function get_service_categories(): array {
    return q('SELECT id, name, slug, blurb FROM service_categories
              ORDER BY sort_order ASC');
}

function get_services(): array {
    return q('SELECT s.*, c.name AS category_name, c.slug AS category_slug
              FROM services s
              JOIN service_categories c ON c.id = s.category_id
              WHERE s.is_active = 1
              ORDER BY c.sort_order ASC, s.sort_order ASC');
}

/** Services grouped by category, ready for the menu view. */
function get_menu(): array {
    $menu = [];
    foreach (get_service_categories() as $cat) {
        $cat['items'] = [];
        $menu[$cat['id']] = $cat;
    }
    foreach (get_services() as $svc) {
        if (isset($menu[$svc['category_id']])) {
            $menu[$svc['category_id']]['items'][] = $svc;
        }
    }
    return array_values($menu);
}

function get_featured_services(int $limit = 4): array {
    return q('SELECT s.*, c.name AS category_name FROM services s
              JOIN service_categories c ON c.id = s.category_id
              WHERE s.is_active = 1 AND s.is_featured = 1
              ORDER BY s.sort_order ASC LIMIT ' . (int) $limit);
}
