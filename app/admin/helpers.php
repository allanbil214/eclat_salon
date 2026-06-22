<?php
/** Dashboard helpers: auth, CSRF, flash, rendering. */
declare(strict_types=1);

/* ---------- admin users / auth ---------- */
function get_admin_by_username(string $u): ?array {
    return q1('SELECT * FROM admin_users WHERE username = :u', ['u' => $u]);
}

function current_admin(): ?array {
    static $cached = false;
    if ($cached !== false) return $cached;
    if (empty($_SESSION['admin_id'])) return $cached = null;
    return $cached = q1('SELECT * FROM admin_users WHERE id = :id', ['id' => (int) $_SESSION['admin_id']]) ?: null;
}

function is_admin_logged_in(): bool { return current_admin() !== null; }

function require_admin(): void {
    if (!is_admin_logged_in()) admin_redirect('/login');
}

/* ---------- urls / redirects ---------- */
function admin_url(string $sub = ''): string {
    $sub = trim($sub, '/');
    return url('admin' . ($sub !== '' ? '/' . $sub : ''));
}
function admin_redirect(string $sub): void {
    header('Location: ' . admin_url($sub));
    exit;
}

/* ---------- CSRF ---------- */
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string {
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}
function csrf_verify(): bool {
    return isset($_POST['_csrf']) && is_string($_POST['_csrf'])
        && hash_equals($_SESSION['csrf'] ?? '', $_POST['_csrf']);
}

/* ---------- flash messages ---------- */
function flash(string $msg, string $type = 'ok'): void {
    $_SESSION['flash'][] = ['msg' => $msg, 'type' => $type];
}
function take_flash(): array {
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

/* ---------- render an admin view inside the admin layout ---------- */
function render_admin(string $view, array $data = []): void {
    $admin_view_file = ADMIN_PATH . '/views/' . $view . '.php';
    $chrome = $data['chrome'] ?? true;            // false = bare (login)
    $active = $data['active'] ?? '';
    extract($data, EXTR_SKIP);
    require ADMIN_PATH . '/views/layout.php';
}

/* ---------- write helper (INSERT/UPDATE/DELETE) ---------- */
function qexec(string $sql, array $params = []): void {
    db()->prepare($sql)->execute($params);
}

/* ---------- dashboard counts ---------- */
function admin_count(string $sql): int {
    return (int) (q1($sql)['c'] ?? 0);
}
function admin_counts(): array {
    return [
        'new_orders' => admin_count("SELECT COUNT(*) c FROM orders WHERE status = 'new'"),
        'orders'     => admin_count('SELECT COUNT(*) c FROM orders'),
        'bookings'   => admin_count('SELECT COUNT(*) c FROM booking_requests'),
        'products'   => admin_count('SELECT COUNT(*) c FROM products'),
        'posts'      => admin_count('SELECT COUNT(*) c FROM posts'),
        'faqs'       => admin_count('SELECT COUNT(*) c FROM faq'),
    ];
}

/* ---------- richer dashboard data ---------- */
function admin_dashboard_data(): array {
    $orders = q('SELECT id, ref, customer_name, total, status, created_at FROM orders ORDER BY created_at DESC');

    // 14-day revenue series (aggregated in PHP for driver portability).
    $today = new DateTimeImmutable('today');
    $days = [];
    for ($i = 13; $i >= 0; $i--) {
        $days[$today->modify("-$i day")->format('Y-m-d')] = 0.0;
    }
    $rev_all = 0.0; $rev_month = 0.0; $month = $today->format('Y-m');
    $status = ['new' => 0, 'contacted' => 0, 'completed' => 0];
    foreach ($orders as $o) {
        $t = (float) $o['total'];
        $rev_all += $t;
        $date = substr((string) $o['created_at'], 0, 10);
        if (isset($days[$date])) $days[$date] += $t;
        if (substr((string) $o['created_at'], 0, 7) === $month) $rev_month += $t;
        $s = (string) $o['status'];
        $status[$s] = ($status[$s] ?? 0) + 1;
    }

    $labels = [];
    foreach (array_keys($days) as $d) $labels[] = date('j/n', strtotime($d));

    $c = admin_counts();
    return [
        'counts'      => $c,
        'rev_all'     => $rev_all,
        'rev_month'   => $rev_month,
        'status'      => $status,
        'chart'       => ['labels' => $labels, 'values' => array_values($days)],
        'recent_orders'   => array_slice($orders, 0, 5),
        'recent_bookings' => q('SELECT id, name, phone, preferred_date, created_at FROM booking_requests ORDER BY created_at DESC, id DESC LIMIT 5'),
    ];
}

