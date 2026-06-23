<?php /** Product detail. Vars: $product $gallery $related $wa_url */ ?>

<section class="section product-detail">
    <div class="container">
        <div class="breadcrumb breadcrumb--dark">
            <a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>
            <a href="<?= e(url('shop')) ?>">Shop</a><span class="sep">/</span><?= e($product['name']) ?>
        </div>

        <div class="pd-grid">
            <!-- Gallery -->
            <div class="pd-gallery reveal">
                <div class="pd-main">
                    <img id="pd-main-img" src="<?= e(image($gallery[0] ?? $product['image_url'])) ?>"
                         alt="<?= e($product['brand'] . ' ' . $product['name']) ?>">
                    <?php if (!$product['in_stock']): ?><span class="stock-badge">Out of stock</span><?php endif; ?>
                </div>
                <?php if (count($gallery) > 1): ?>
                <div class="pd-thumbs">
                    <?php foreach ($gallery as $i => $img): ?>
                        <button type="button" class="pd-thumb<?= $i === 0 ? ' active' : '' ?>"
                                data-full="<?= e(image($img)) ?>" aria-label="View image <?= $i + 1 ?>">
                            <img src="<?= e(image($img)) ?>" alt="" loading="lazy">
                        </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Info -->
            <div class="pd-info reveal" style="--d:.08s">
                <span class="product-brand"><?= e($product['brand']) ?></span>
                <h1 class="pd-name"><?= e($product['name']) ?></h1>
                <div class="pd-price"><?= e(money((float) $product['price'])) ?></div>
                <div class="pd-stock <?= $product['in_stock'] ? 'in' : 'out' ?>">
                    <?= $product['in_stock'] ? '● In stock — available in-salon' : '● Currently out of stock' ?>
                </div>
                <div class="pd-desc"><?= $product['description'] ?></div>

                <div class="pd-actions">
                    <?php if ($product['in_stock']): ?>
                        <div class="qty-stepper" data-qty>
                            <button type="button" data-qty-dec aria-label="Decrease quantity">−</button>
                            <input type="text" inputmode="numeric" value="1" data-qty-input aria-label="Quantity">
                            <button type="button" data-qty-inc aria-label="Increase quantity">+</button>
                        </div>
                        <button class="btn btn-primary" type="button"
                                data-add-to-cart data-from-qty
                                data-id="<?= (int) $product['id'] ?>"
                                data-slug="<?= e($product['slug']) ?>"
                                data-name="<?= e($product['name']) ?>"
                                data-brand="<?= e($product['brand']) ?>"
                                data-price="<?= e((string) (float) $product['price']) ?>"
                                data-image="<?= e(image($product['image_url'])) ?>">Add to cart</button>
                        <?php if ($wa_url): ?>
                            <a class="btn btn-ghost" href="<?= e($wa_url) ?>" target="_blank" rel="noopener">Enquire <span aria-hidden="true">→</span></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="btn btn-ghost" aria-disabled="true">Currently unavailable</span>
                        <a class="btn btn-ghost" href="<?= e(url('shop')) ?>">Back to shop</a>
                    <?php endif; ?>
                </div>

                <ul class="pd-meta">
                    <li><span>Brand</span><strong><?= e($product['brand']) ?></strong></li>
                    <li><span>Availability</span><strong><?= $product['in_stock'] ? 'In-salon' : 'Out of stock' ?></strong></li>
                    <li><span>Enquiries</span><strong>WhatsApp &amp; in-salon</strong></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php if ($related): ?>
<section class="section section--alt">
    <div class="container">
        <div class="section-head split">
            <div><span class="eyebrow">More to love</span><h2 style="margin-top:22px">You might also like</h2></div>
            <a class="btn-text" href="<?= e(url('shop')) ?>">All products <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="product-grid">
            <?php foreach ($related as $p): ?>
                <article class="product-card reveal<?= $p['in_stock'] ? '' : ' is-out' ?>">
                    <a class="product-media" href="<?= e(url('shop/' . $p['slug'])) ?>">
                        <img src="<?= e(image($p['image_url'])) ?>" alt="<?= e($p['brand'] . ' ' . $p['name']) ?>" loading="lazy">
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
<?php endif; ?>

<?php partial('posts-strip', ['posts' => $articles, 'eyebrow' => 'Article', 'heading' => 'Hair tips & inspiration']); ?>
