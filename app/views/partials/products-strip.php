<?php /** Products strip. Expects $products; optional $eyebrow, $heading, $alt. */
$eyebrow = $eyebrow ?? 'The shelf';
$heading = $heading ?? 'Take the salon home';
$alt     = $alt ?? false;
if (empty($products)) return;
?>
<section class="section<?= $alt ? ' section--alt' : '' ?>">
    <div class="container">
        <div class="section-head split">
            <div><span class="eyebrow"><?= e($eyebrow) ?></span><h2 style="margin-top:22px"><?= e($heading) ?></h2></div>
            <a class="btn-text" href="<?= e(url('shop')) ?>">All products <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="product-grid product-grid--4">
            <?php foreach ($products as $p): ?>
                <article class="product-card reveal<?= $p['in_stock'] ? '' : ' is-out' ?>">
                    <a class="product-media" href="<?= e(url('shop/' . $p['slug'])) ?>">
                        <img src="<?= e(image($p['image_url'])) ?>" alt="<?= e($p['brand'] . ' ' . $p['name']) ?>" loading="lazy">
                        <?php if (!$p['in_stock']): ?><span class="stock-badge">Out of stock</span><?php endif; ?>
                    </a>
                    <div class="product-body">
                        <span class="product-brand"><?= e($p['brand']) ?></span>
                        <h3 class="product-name"><a href="<?= e(url('shop/' . $p['slug'])) ?>"><?= e($p['name']) ?></a></h3>
                        <div class="product-foot">
                            <span class="product-price"><?= e(money((float) $p['price'])) ?></span>
                            <a class="product-wa" href="<?= e(url('shop/' . $p['slug'])) ?>">View <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
