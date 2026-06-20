<?php
/**
 * Small helpers used across views. All plain functions — no classes.
 */
declare(strict_types=1);

/** Escape a string for safe HTML output. Use on every dynamic value. */
function e(?string $s): string {
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** A root-relative URL that respects BASE_URL. */
function url(string $path = ''): string {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Resolve an image source. External URLs (http…) pass through untouched;
 * local paths get the BASE_URL prefix so they work in a subfolder.
 */
function image(string $path): string {
    if ($path === '') return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    return url(ltrim($path, '/'));
}

/**
 * Cache-busting version stamp for an asset (its last-modified time).
 * Swap a file and the URL changes automatically — no manual versioning,
 * and the browser never serves a stale copy.
 */
function asset_version(string $relative): string {
    $file = PUBLIC_PATH . '/assets/' . ltrim($relative, '/');
    return is_file($file) ? (string) filemtime($file) : '1';
}

/** A <link> tag for a stylesheet under /assets/css (no extension needed). */
function css(string $name): string {
    $rel = 'css/' . $name . '.css';
    return '<link rel="stylesheet" href="' . e(url('assets/' . $rel))
        . '?v=' . asset_version($rel) . '">';
}

/** A <script defer> tag for a script under /assets/js (no extension needed). */
function js(string $name): string {
    $rel = 'js/' . $name . '.js';
    return '<script defer src="' . e(url('assets/' . $rel))
        . '?v=' . asset_version($rel) . '"></script>';
}

/** Format a price the way a salon menu does (e.g. "Rp 1.500.000"). The
 *  space after Rp is non-breaking so a price never splits across two lines. */
function money(?float $amount): string {
    if ($amount === null) return '';
    return get_setting('currency_symbol', 'Rp') . "\u{00A0}" . number_format($amount, 0, ',', '.');
}

/** A service price as a range, a "from" figure, or "on request". */
function price_label(array $service): string {
    $from = isset($service['price_from']) ? (float) $service['price_from'] : null;
    $to   = (isset($service['price_to']) && $service['price_to'] !== null)
        ? (float) $service['price_to'] : null;
    if ($from === null)              return 'On request';
    if ($to !== null && $to > $from) return money($from) . '–' . money($to);
    return 'from ' . money($from);
}

/** Render a star rating (1–5) as filled/empty glyphs. */
function stars(int $rating): string {
    $rating = max(0, min(5, $rating));
    return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
}

/** Read the current theme from the cookie so PHP can render it server-side
 *  (this is what prevents a flash of the wrong theme on load — no inline JS). */
function current_theme(): string {
    $t = $_COOKIE['theme'] ?? 'dark';
    return $t === 'light' ? 'light' : 'dark';
}

/** Format a 24h "HH:MM:SS" time as "10:00 AM". */
function fmt_time(?string $time): string {
    if (!$time) return '';
    $ts = strtotime($time);
    return $ts ? date('g:i A', $ts) : $time;
}

/**
 * Render a page template inside the main layout.
 * Controllers call this last; $data keys become variables in the view.
 */
function render(string $page, array $data = []): void {
    extract($data, EXTR_SKIP);
    $view_file = VIEWS_PATH . '/pages/' . $page . '.php';
    require VIEWS_PATH . '/layout.php';
}

/** Include a partial from app/views/partials, optionally passing data. */
function partial(string $name, array $data = []): void {
    extract($data, EXTR_SKIP);
    require VIEWS_PATH . '/partials/' . $name . '.php';
}
