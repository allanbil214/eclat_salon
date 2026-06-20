<?php /** Services page. Vars: $menu (categories with ->items) */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/services-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">Services &amp; pricing</span>
        <h1>The menu</h1>
        <p class="lede">Transparent pricing, generous appointment times, and a consultation built into everything we do.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>Services</div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="svc-intro reveal">
            <div>
                <span class="eyebrow">Where to start</span>
                <h2 style="margin-top:22px">Find your service</h2>
            </div>
            <nav class="svc-jump" aria-label="Service categories">
                <?php foreach ($menu as $cat): ?>
                    <a href="#cat-<?= e($cat['slug']) ?>"><?= e($cat['name']) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>

        <?php foreach ($menu as $cat): ?>
            <div class="menu-cat reveal" id="cat-<?= e($cat['slug']) ?>">
                <div class="menu-cat__head">
                    <h3><?= e($cat['name']) ?></h3>
                    <p class="blurb"><?= e($cat['blurb']) ?></p>
                </div>
                <?php foreach ($cat['items'] as $svc): ?>
                    <div class="menu-row">
                        <div class="nm">
                            <?= e($svc['name']) ?>
                            <?php if ($svc['is_featured']): ?><span class="tag">Signature</span><?php endif; ?>
                        </div>
                        <div class="price"><?= e(price_label($svc)) ?></div>
                        <p class="desc"><?= e($svc['description']) ?></p>
                        <div class="dur"><?= $svc['duration_min'] ? (int) $svc['duration_min'] . ' min' : 'Varies' ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php partial('cta', ['cta_title' => 'Not sure which service you need?', 'cta_text' => 'Request an appointment and tell us your hair goals — we will recommend the right service and stylist.']); ?>
