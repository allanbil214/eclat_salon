<?php /** Brand marquee. Pulls product brands and loops them seamlessly. */
$brands = get_brands();
if (!$brands) return; ?>
<div class="marquee" aria-label="Brands we use">
    <div class="marquee__track">
        <?php for ($i = 0; $i < 2; $i++): ?>
            <?php foreach ($brands as $b): ?>
                <?php
                $inner = !empty($b['logo_url'])
                    ? '<img src="' . e(image($b['logo_url'])) . '" alt="' . e($b['name']) . '">'
                    : '<span class="marquee__name">' . e($b['name']) . '</span>';
                if (!empty($b['website_url'])) {
                    echo '<a class="marquee__item" href="' . e($b['website_url']) . '" target="_blank" rel="noopener">' . $inner . '</a>';
                } else {
                    echo '<span class="marquee__item">' . $inner . '</span>';
                }
                ?>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
