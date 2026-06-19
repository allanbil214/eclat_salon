<?php /** Brand marquee. Pulls product brands and loops them seamlessly. */
$brands = get_brands();
if (!$brands) return; ?>
<div class="marquee" aria-label="Brands we use">
    <div class="marquee__track">
        <?php for ($i = 0; $i < 2; $i++): ?>
            <?php foreach ($brands as $b): ?>
                <span><?= e($b['name']) ?></span>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>
