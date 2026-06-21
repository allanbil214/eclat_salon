<?php /** Shop page. Vars: $products $brands */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/shop-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">The shelf</span>
        <h1>Take the salon home</h1>
        <p class="lede">The same professional brands we reach for in the chair — so your hair keeps its health and shine between visits.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>Shop</div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($brands): ?>
        <div class="filter-bar reveal">
            <button class="active" data-filter="all" type="button">All</button>
            <?php foreach ($brands as $b): ?>
                <button data-filter="<?= e($b) ?>" type="button"><?= e($b) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="product-grid">
            <?php foreach ($products as $i => $p): ?>
                <article class="product-card reveal<?= $p['in_stock'] ? '' : ' is-out' ?>"
                         data-brand="<?= e($p['brand']) ?>" style="--d:<?= number_format(($i % 4) * 0.05, 2) ?>s">
                    <a class="product-media" href="<?= e(url('shop/' . $p['slug'])) ?>">
                        <img src="<?= e(image($p['image_url'])) ?>" alt="<?= e($p['brand'] . ' ' . $p['name']) ?>" loading="lazy">
                        <?php if (!$p['in_stock']): ?><span class="stock-badge">Out of stock</span><?php endif; ?>
                    </a>
                    <div class="product-body">
                        <span class="product-brand"><?= e($p['brand']) ?></span>
                        <h3 class="product-name"><a href="<?= e(url('shop/' . $p['slug'])) ?>"><?= e($p['name']) ?></a></h3>
                        <p class="product-desc"><?= e($p['description']) ?></p>
                        <div class="product-foot">
                            <span class="product-price"><?= e(money((float) $p['price'])) ?></span>
                            <?php if ($p['in_stock']): ?>
                                <a class="product-wa" href="<?= e(whatsapp_product_url($p)) ?>" target="_blank" rel="noopener">
                                    Enquire <span aria-hidden="true">→</span>
                                </a>
                            <?php else: ?>
                                <span class="product-wa muted">Unavailable</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($p['in_stock']): ?>
                            <button class="btn btn-ghost btn-add" type="button"
                                    data-add-to-cart
                                    data-id="<?= (int) $p['id'] ?>"
                                    data-slug="<?= e($p['slug']) ?>"
                                    data-name="<?= e($p['name']) ?>"
                                    data-brand="<?= e($p['brand']) ?>"
                                    data-price="<?= e((string) (float) $p['price']) ?>"
                                    data-image="<?= e(image($p['image_url'])) ?>">Add to cart</button>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="shop-note reveal">Products are available to purchase in-salon, or tap <strong>Enquire</strong> to ask about availability and delivery on WhatsApp.</p>
    </div>
</section>

<?php partial('cta', ['cta_title' => 'Not sure what your hair needs?', 'cta_text' => 'Book in and your stylist will build a simple at-home routine — and you can pick it up on the way out.']); ?>
