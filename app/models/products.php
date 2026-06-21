<?php
/** Retail products sold in-salon. */
declare(strict_types=1);

function get_products(?string $brand = null): array {
    $sql = 'SELECT * FROM products';
    $params = [];
    if ($brand !== null && $brand !== 'all') {
        $sql .= ' WHERE brand = :brand';
        $params['brand'] = $brand;
    }
    $sql .= ' ORDER BY sort_order ASC';
    return q($sql, $params);
}

/** A few in-stock products for the homepage shelf strip. */
function get_featured_products(int $limit = 4): array {
    return q(
        'SELECT * FROM products WHERE in_stock = 1 ORDER BY sort_order ASC LIMIT ' . (int) $limit
    );
}

/** Distinct brands present in the shop, for the filter bar. */
function get_product_brands(): array {
    return array_column(
        q('SELECT brand FROM products GROUP BY brand ORDER BY MIN(sort_order) ASC'),
        'brand'
    );
}

/** One product by its slug (or null). */
function get_product_by_slug(string $slug): ?array {
    return q1('SELECT * FROM products WHERE slug = :slug', ['slug' => $slug]);
}

/** All gallery images for a product: the main image first, then the extras. */
function get_product_gallery(array $product): array {
    $images = [];
    if (!empty($product['image_url'])) {
        $images[] = $product['image_url'];
    }
    foreach (q('SELECT image_url FROM product_images WHERE product_id = :id ORDER BY sort_order ASC',
               ['id' => (int) $product['id']]) as $row) {
        $images[] = $row['image_url'];
    }
    return $images;
}

/** A few other products to suggest (same brand first, then others). */
function get_related_products(array $product, int $limit = 3): array {
    return q(
        'SELECT * FROM products WHERE id <> :id
         ORDER BY (brand = :brand) DESC, sort_order ASC
         LIMIT ' . (int) $limit,
        ['id' => (int) $product['id'], 'brand' => $product['brand']]
    );
}

/** A wa.me link pre-filled with an enquiry about a single product. */
function whatsapp_product_url(array $product): string {
    $number = preg_replace('/\D+/', '', get_setting('whatsapp'));
    if ($number === '') {
        return '';
    }
    $text = 'Halo ÉCLAT! Saya tertarik dengan produk: '
        . trim(($product['brand'] ?? '') . ' ' . ($product['name'] ?? ''))
        . '. Apakah tersedia?';
    return 'https://wa.me/' . $number . '?text=' . rawurlencode($text);
}
