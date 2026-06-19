<?php
/**
 * One shared database connection + two tiny query helpers.
 * Models call db() / q() / q1(); nothing builds SQL by string-concatenation.
 */
declare(strict_types=1);

/** The single shared PDO connection (created on first use). */
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $opts = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        if (DB_DRIVER === 'sqlite') {
            $pdo = new PDO('sqlite:' . DB_SQLITE_PATH, null, null, $opts);
            $pdo->exec('PRAGMA foreign_keys = ON');
        } else {
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                DB_HOST, DB_PORT, DB_NAME);
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
        }
    } catch (PDOException $ex) {
        http_response_code(500);
        exit(APP_DEBUG
            ? 'Database connection failed: ' . $ex->getMessage()
            : 'The site is temporarily unavailable. Please try again shortly.');
    }
    return $pdo;
}

/** Run a prepared query and return every row. */
function q(string $sql, array $params = []): array {
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/** Run a prepared query and return the first row, or null. */
function q1(string $sql, array $params = []): ?array {
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}
