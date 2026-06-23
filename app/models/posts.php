<?php
/** Blog posts ("Article"). */
declare(strict_types=1);

/** Published posts, newest first, optionally filtered by category. */
function get_posts(?string $category = null): array {
    $sql = 'SELECT * FROM posts WHERE is_published = 1';
    $params = [];
    if ($category !== null && $category !== 'all') {
        $sql .= ' AND category = :category';
        $params['category'] = $category;
    }
    $sql .= ' ORDER BY published_at DESC, id DESC';
    return q($sql, $params);
}

/** Distinct categories in use, for the filter bar. */
function get_post_categories(): array {
    return array_column(
        q("SELECT category FROM posts WHERE is_published = 1 AND category <> ''
           GROUP BY category ORDER BY MIN(published_at) DESC"),
        'category'
    );
}

/** One published post by slug (or null). */
function get_post_by_slug(string $slug): ?array {
    return q1('SELECT * FROM posts WHERE slug = :slug AND is_published = 1', ['slug' => $slug]);
}

/** A few recent posts for teasers / "more reading" (optionally excluding one). */
function get_recent_posts(int $limit = 3, int $exclude_id = 0): array {
    return q(
        'SELECT * FROM posts WHERE is_published = 1 AND id <> :ex
         ORDER BY published_at DESC, id DESC LIMIT ' . (int) $limit,
        ['ex' => $exclude_id]
    );
}

/** Rough reading time in minutes from the (HTML) body. */
function reading_time(string $body): int {
    $words = str_word_count(strip_tags($body));
    return max(1, (int) ceil($words / 200));
}

/** A human date like "28 May 2026". */
function post_date(?string $dt): string {
    if (!$dt) return '';
    $ts = strtotime($dt);
    return $ts ? date('j M Y', $ts) : '';
}

/* ---------------- dashboard (admin) helpers ---------------- */

/** All posts incl. drafts, newest first. */
function get_all_posts(): array {
    return q('SELECT * FROM posts ORDER BY id DESC');
}

/** One post by id, or null. */
function get_post_by_id(int $id): ?array {
    return q1('SELECT * FROM posts WHERE id = :id', ['id' => $id]);
}

/** Ensure a post slug is unique. */
function unique_post_slug(string $slug, int $ignore_id = 0): string {
    $slug = $slug !== '' ? $slug : 'post';
    $base = $slug; $i = 2;
    while (q1('SELECT id FROM posts WHERE slug = :s AND id <> :id', ['s' => $slug, 'id' => $ignore_id])) {
        $slug = $base . '-' . $i++;
    }
    return $slug;
}
