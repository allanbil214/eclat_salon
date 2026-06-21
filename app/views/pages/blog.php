<?php /** Blog index. Vars: $posts $categories */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/blog-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">Article</span>
        <h1>Notes from the chair</h1>
        <p class="lede">Hair tips, colour trends and the little rituals that keep your hair looking its best between visits.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>Article</div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if ($categories): ?>
        <div class="filter-bar reveal">
            <button class="active" data-filter="all" type="button">All</button>
            <?php foreach ($categories as $c): ?>
                <button data-filter="<?= e($c) ?>" type="button"><?= e($c) ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($posts): ?>
            <div class="post-grid">
                <?php foreach ($posts as $post) partial('post-card', ['post' => $post]); ?>
            </div>
        <?php else: ?>
            <p class="shop-note reveal">No articles yet — check back soon.</p>
        <?php endif; ?>
    </div>
</section>

<?php partial('cta'); ?>
