<?php
/** Site header / navigation. Expects $active, $solid. */
$active = $active ?? '';
$solid  = $solid  ?? false;
$links = [
    'home'     => ['Home', url('')],
    'about'    => ['About', url('about')],
    'services' => ['Services', url('services')],
    'gallery'  => ['Gallery', url('gallery')],
    'shop'     => ['Shop', url('shop')],
];
?>
<header class="site-header<?= $solid ? ' is-solid' : '' ?>">
    <div class="container header-inner">
        <a class="brand" href="<?= e(url('')) ?>" aria-label="<?= e(get_setting('site_name_full')) ?>">
            <?= e(get_setting('site_name')) ?><span class="dot">.</span>
        </a>

        <nav class="nav" aria-label="Primary">
            <div class="nav-links">
                <?php foreach ($links as $key => [$label, $href]): ?>
                    <a href="<?= e($href) ?>"<?= $active === $key ? ' class="is-active"' : '' ?>><?= e($label) ?></a>
                <?php endforeach; ?>
            </div>
            <a class="btn btn-primary" href="<?= e(url('book')) ?>">Book Now</a>
        </nav>

        <div class="header-actions">
            <button class="cart-toggle" type="button" data-cart-open aria-label="Open cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M6 7h12l-1 12a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L6 7z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
                <span class="cart-badge" data-cart-count hidden>0</span>
            </button>
            <button class="theme-toggle" type="button" aria-label="Switch theme">
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="4.5"/><path d="M12 2v2M12 20v2M2 12h2M20 12h2M5 5l1.5 1.5M17.5 17.5L19 19M19 5l-1.5 1.5M6.5 17.5L5 19"/></svg>
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M21 12.8A8.5 8.5 0 1 1 11.2 3a6.5 6.5 0 0 0 9.8 9.8z"/></svg>
            </button>
            <a class="btn btn-primary" href="<?= e(url('book')) ?>">Book Now</a>
            <button class="nav-toggle" type="button" aria-label="Menu" aria-expanded="false" aria-controls="main">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>

<a class="btn btn-primary book-fab" href="<?= e(url('book')) ?>">Book</a>
