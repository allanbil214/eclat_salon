<?php /** Home page. Vars from HomeController: $stats $featured $transformations $team $gallery $testimonials */ ?>

<section class="hero">
    <div class="hero-bg"><img src="<?= e(url('assets/img/hero/home-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container hero-inner">
        <span class="eyebrow"><?= e(get_setting('hero_eyebrow')) ?></span>
        <h1><?= e(get_setting('hero_title')) ?></h1>
        <p class="lede"><?= e(get_setting('hero_lead')) ?></p>
        <div class="hero-cta">
            <a class="btn btn-primary" href="<?= e(url('book')) ?>">Book an appointment</a>
            <a class="btn btn-on-image" href="<?= e(url('gallery')) ?>">View the lookbook</a>
        </div>
    </div>
    <div class="hero-meta">
        <span class="num">4.9</span>
        <span class="lbl">★ from 2,400+ reviews</span>
    </div>
    <div class="scroll-hint"><span>Scroll</span><span class="line"></span></div>
</section>

<?php partial('marquee'); ?>

<!-- About teaser -->
<section class="section">
    <div class="container intro-split">
        <div class="intro-figure reveal">
            <div class="main"><img src="<?= e(url('assets/img/home/intro.jpg')) ?>" alt="Inside the ÉCLAT atelier" loading="lazy"></div>
            <div class="badge">
                <div class="n"><?= (int) (date('Y') - (int) get_setting('founded_year')) ?></div>
                <div class="l">Years in Jakarta</div>
            </div>
        </div>
        <div class="intro-copy reveal" style="--d:.1s">
            <span class="eyebrow"><?= e(get_setting('about_eyebrow')) ?></span>
            <h2 style="margin-top:22px"><?= e(get_setting('about_title')) ?></h2>
            <p><?= e(get_setting('about_p1')) ?></p>
            <p><?= e(get_setting('about_p2')) ?></p>
            <a class="btn-text" href="<?= e(url('about')) ?>">More about the house <span class="arrow" aria-hidden="true">→</span></a>
        </div>
    </div>
</section>

<!-- Stat band -->
<section class="section--tight">
    <div class="stat-band">
        <?php foreach ($stats as $s): ?>
            <div class="stat reveal">
                <div class="num"><?= e($s['prefix']) ?><span data-count="<?= (int) $s['value'] ?>">0</span><span class="accent"><?= e($s['suffix']) ?></span></div>
                <div class="lbl"><?= e($s['label']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Services preview -->
<section class="section section--alt">
    <div class="container">
        <div class="section-head split">
            <div>
                <span class="eyebrow">Signature services</span>
                <h2 style="margin-top:22px">What we are known for</h2>
            </div>
            <a class="btn-text" href="<?= e(url('services')) ?>">Full menu &amp; pricing <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="preview-services">
            <?php foreach ($featured as $i => $svc): ?>
                <a class="svc-feature reveal" href="<?= e(url('services')) ?>">
                    <span class="ix"><?= sprintf('%02d', $i + 1) ?></span>
                    <span class="nm"><?= e($svc['name']) ?><small><?= e($svc['category_name']) ?></small></span>
                    <span class="pr"><?= e(price_label($svc)) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Transformations (signature before/after) -->
<?php if ($transformations): ?>
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow eyebrow--center">The proof</span>
            <h2 style="margin-top:22px">Drag to see the transformation</h2>
            <p class="lede">Real ÉCLAT work. Pull the handle across to reveal before and after.</p>
        </div>
        <?php $baCarousel = count($transformations) > 3; ?>
        <div class="ba-carousel<?= $baCarousel ? ' is-carousel' : '' ?>"<?= $baCarousel ? ' data-ba-carousel' : '' ?>>
            <div class="ba-track">
                <?php foreach ($transformations as $i => $t): ?>
                    <div class="ba-slide reveal" style="--d:<?= number_format($i * 0.08, 2) ?>s">
                        <div class="ba" style="--pos:50%">
                            <img class="before" src="<?= e(image($t['before_image_url'])) ?>" alt="Before">
                            <span class="tag before">Before</span>
                            <div class="ba-after">
                                <img class="after" src="<?= e(image($t['image_url'])) ?>" alt="After: <?= e($t['title']) ?>">
                                <span class="tag after">After</span>
                            </div>
                            <div class="handle"><span class="grip" aria-hidden="true">⇄</span></div>
                        </div>
                        <div class="ba-caption">
                            <span class="t"><?= e($t['title']) ?></span>
                            <?php if ($t['stylist_name']): ?><span class="b">by <?= e($t['stylist_name']) ?></span><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($baCarousel): ?>
                <button class="ba-nav ba-prev" type="button" aria-label="Previous" data-ba-prev>‹</button>
                <button class="ba-nav ba-next" type="button" aria-label="Next" data-ba-next>›</button>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Team peek -->
<section class="section section--alt">
    <div class="container">
        <div class="section-head split">
            <div>
                <span class="eyebrow">The hands behind ÉCLAT</span>
                <h2 style="margin-top:22px">Master stylists, not a conveyor belt</h2>
            </div>
            <a class="btn-text" href="<?= e(url('about')) ?>">Meet the full team <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <?php partial('team-grid', ['members' => $team]); ?>
    </div>
</section>

<!-- Lookbook strip -->
<section class="section">
    <div class="container">
        <div class="section-head split">
            <div>
                <span class="eyebrow">Lookbook</span>
                <h2 style="margin-top:22px">A few recent looks</h2>
            </div>
            <a class="btn-text" href="<?= e(url('gallery')) ?>">See the full gallery <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="grid grid-3">
            <?php foreach ($gallery as $i => $g): ?>
                <a class="tile reveal" href="<?= e(url('gallery')) ?>" style="--d:<?= number_format(($i % 3) * 0.06, 2) ?>s">
                    <img src="<?= e(image($g['image_url'])) ?>" alt="<?= e($g['title']) ?>" loading="lazy">
                    <span class="meta">
                        <span class="cat"><?= e($g['category_name']) ?></span>
                        <span class="ttl"><?= e($g['title']) ?></span>
                        <?php if ($g['stylist_name']): ?><span class="by">by <?= e($g['stylist_name']) ?></span><?php endif; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Shop the shelf -->
<?php partial('products-strip', ['products' => $shop_products, 'eyebrow' => 'The shelf', 'heading' => 'Take the salon home']); ?>

<!-- Reviews -->
<section class="section section--alt">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow eyebrow--center">Guest love</span>
            <h2 style="margin-top:22px">Twenty-four hundred reasons to trust us</h2>
        </div>
        <?php partial('testimonials', ['items' => $testimonials]); ?>
    </div>
</section>

<?php partial('posts-strip', ['posts' => $articles, 'eyebrow' => 'Article', 'heading' => 'From the studio']); ?>

<?php partial('cta'); ?>
