<?php /** Admin layout. Vars: $title, $chrome, $active, $admin_view_file */
$adm_theme = (($_COOKIE['adm_theme'] ?? 'light') === 'dark') ? 'dark' : 'light';
?>
<!doctype html>
<html lang="en" data-theme="<?= $adm_theme ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e(($title ?? 'Admin') . ' — ÉCLAT Admin') ?></title>
    <?= css('admin') ?>
</head>
<body class="adm<?= $chrome ? '' : ' adm--bare' ?>">
<?php if ($chrome): ?>
    <?php require ADMIN_PATH . '/views/partials/sidebar.php'; ?>
    <div class="adm-main">
        <header class="adm-top">
            <div class="adm-top-title"><?= e($title ?? '') ?></div>
            <div class="adm-top-right">
                <button class="adm-theme-toggle" type="button" data-adm-theme-toggle aria-label="Toggle light / dark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
                </button>
                <a class="adm-viewsite" href="<?= e(url('')) ?>" target="_blank" rel="noopener">View site ↗</a>
                <span class="adm-user"><?= e(current_admin()['name'] ?? 'Admin') ?></span>
                <form method="post" action="<?= e(admin_url('logout')) ?>" class="adm-logout"><?= csrf_field() ?><button type="submit">Log out</button></form>
            </div>
        </header>
        <main class="adm-content">
            <?php require ADMIN_PATH . '/views/partials/flash.php'; ?>
            <?php require $admin_view_file; ?>
        </main>
    </div>
<?php else: ?>
    <main class="adm-bare">
        <?php require ADMIN_PATH . '/views/partials/flash.php'; ?>
        <?php require $admin_view_file; ?>
    </main>
<?php endif; ?>
    <?= js('admin') ?>
</body>
</html>
