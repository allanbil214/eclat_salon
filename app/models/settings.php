<?php
/** Site-wide key/value settings. */
declare(strict_types=1);

/** Get one setting, cached for the request. */
function get_setting(string $key, string $default = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        foreach (q('SELECT skey, svalue FROM settings') as $r) {
            $cache[$r['skey']] = $r['svalue'];
        }
    }
    return $cache[$key] ?? $default;
}

/* ---------------- dashboard (admin) helpers ---------------- */
/** All settings as skey => svalue. */
function get_all_settings(): array {
    $out = [];
    foreach (q('SELECT skey, svalue FROM settings') as $r) $out[$r['skey']] = $r['svalue'];
    return $out;
}
/** Upsert one setting (portable across MySQL/SQLite). */
function put_setting(string $key, string $value): void {
    if (q1('SELECT id FROM settings WHERE skey = :k', ['k' => $key])) {
        qexec('UPDATE settings SET svalue = :v WHERE skey = :k', ['v' => $value, 'k' => $key]);
    } else {
        qexec('INSERT INTO settings (skey, svalue) VALUES (:k, :v)', ['k' => $key, 'v' => $value]);
    }
}
