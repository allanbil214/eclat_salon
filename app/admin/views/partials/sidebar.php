<?php /** Admin sidebar. Var: $active */
$nav = [
    'dashboard'    => ['Dashboard', admin_url('')],
    'orders'       => ['Orders', admin_url('orders')],
    'bookings'     => ['Bookings', admin_url('bookings')],
    'products'     => ['Products', admin_url('products')],
    'services'     => ['Services', admin_url('services')],
    'team'         => ['Team', admin_url('team')],
    'gallery'      => ['Gallery', admin_url('gallery')],
    'hero_slides'  => ['Hero Slides', admin_url('hero-slides')],
    'articles'     => ['Articles', admin_url('articles')],
    'pages'        => ['Pages', admin_url('pages')],
    'testimonials' => ['Testimonials', admin_url('testimonials')],
    'brands'       => ['Brands', admin_url('brands')],
    'faq'          => ['FAQ', admin_url('faq')],
    'stats'        => ['Stats', admin_url('stats')],
    'hours'        => ['Opening hours', admin_url('hours')],
    'settings'     => ['Settings', admin_url('settings')],
];
$soon = [];
?>
<aside class="adm-side">
    <div class="adm-brand"><a href="<?= e(admin_url('')) ?>">ÉCLAT<span>.</span></a><small>Dashboard</small></div>
    <nav class="adm-nav">
        <?php foreach ($nav as $key => [$label, $href]): ?>
            <a href="<?= e($href) ?>"<?= $active === $key ? ' class="on"' : '' ?>><?= e($label) ?></a>
        <?php endforeach; ?>
        <?php if ($soon): ?>
            <div class="adm-nav-soon">Coming soon</div>
            <?php foreach ($soon as $s): ?><span class="adm-nav-dis"><?= e($s) ?></span><?php endforeach; ?>
        <?php endif; ?>
    </nav>
</aside>
