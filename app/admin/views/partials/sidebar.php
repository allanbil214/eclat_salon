<?php
/** Admin sidebar. Var: $active */

$nav = [
    // Overview
    'dashboard'    => ['Dashboard', admin_url(''), 'fa-solid fa-gauge-high'],

    // Commerce
    'orders'       => ['Orders', admin_url('orders'), 'fa-solid fa-cart-shopping'],
    'bookings'     => ['Bookings', admin_url('bookings'), 'fa-solid fa-calendar-check'],
    'products'     => ['Products', admin_url('products'), 'fa-solid fa-box'],
    'services'     => ['Services', admin_url('services'), 'fa-solid fa-bell-concierge'],

    // Content
    'hero_slides'  => ['Hero Slides', admin_url('hero-slides'), 'fa-solid fa-images'],
    'gallery'      => ['Gallery', admin_url('gallery'), 'fa-solid fa-photo-film'],
    'articles'     => ['Articles', admin_url('articles'), 'fa-solid fa-newspaper'],
    'pages'        => ['Pages', admin_url('pages'), 'fa-solid fa-file-lines'],

    // Reputation
    'testimonials' => ['Testimonials', admin_url('testimonials'), 'fa-solid fa-comment'],
    'brands'       => ['Brands', admin_url('brands'), 'fa-solid fa-tag'],
    'faq'          => ['FAQ', admin_url('faq'), 'fa-solid fa-circle-question'],

    // Team
    'team'         => ['Team', admin_url('team'), 'fa-solid fa-user-group'],
    'hours'        => ['Opening Hours', admin_url('hours'), 'fa-solid fa-clock'],

    // System
    'stats'        => ['Stats', admin_url('stats'), 'fa-solid fa-chart-line'],
    'settings'     => ['Settings', admin_url('settings'), 'fa-solid fa-gear'],
];

$groups = [
    'dashboard'   => ['Overview', 'fa-solid fa-house'],
    'orders'      => ['Commerce', 'fa-solid fa-store'],
    'hero_slides' => ['Content', 'fa-solid fa-pen-fancy'],
    'testimonials'=> ['Reputation', 'fa-solid fa-star'],
    'team'        => ['Team', 'fa-solid fa-user-group'],
    'stats'       => ['System', 'fa-solid fa-sliders'],
];

$soon = [];
?>

<aside class="adm-side">
    <div class="adm-brand">
        <a href="<?= e(admin_url('')) ?>">ÉCLAT<span>.</span></a>
        <small>Dashboard</small>
    </div>

    <nav class="adm-nav">
        <?php
        $current_group = null;

        foreach ($nav as $key => [$label, $href, $icon]) {

            $group = null;
            $group_icon = null;

            foreach ($groups as $first_key => [$group_name, $group_icon_name]) {
                if ($key === $first_key) {
                    $group = $group_name;
                    $group_icon = $group_icon_name;
                    break;
                }
            }

            if ($group !== null) {

                if ($current_group !== null) {
                    echo '</div>';
                }

                echo '<div class="adm-nav-group">';
                echo '<span class="adm-nav-group-label">';
                echo '<i class="' . e($group_icon) . '"></i> ';
                echo e($group);
                echo '</span>';

                $current_group = $group;
            }
            ?>
            
            <a href="<?= e($href) ?>"<?= $active === $key ? ' class="on"' : '' ?>>
                <i class="<?= e($icon) ?>"></i>
                <span><?= e($label) ?></span>
            </a>

            <?php
        }

        if ($current_group !== null) {
            echo '</div>';
        }
        ?>

        <?php if (!empty($soon)): ?>
            <div class="adm-nav-soon">Coming Soon</div>

            <?php foreach ($soon as $s): ?>
                <span class="adm-nav-dis"><?= e($s) ?></span>
            <?php endforeach; ?>

        <?php endif; ?>
    </nav>
</aside>