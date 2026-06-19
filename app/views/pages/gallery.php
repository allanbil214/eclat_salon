<?php /** Gallery page. Vars: $categories $items */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="https://picsum.photos/seed/eclat-gal-hero/1920/1000" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">Lookbook</span>
        <h1>Work from our chairs</h1>
        <p class="lede">Colour, cuts, texture and occasion hair — a selection of recent ÉCLAT transformations.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>Gallery</div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="filter-bar reveal">
            <button class="active" data-filter="all" type="button">All</button>
            <?php foreach ($categories as $c): ?>
                <button data-filter="<?= e($c['slug']) ?>" type="button"><?= e($c['name']) ?></button>
            <?php endforeach; ?>
        </div>

        <div class="masonry">
            <?php foreach ($items as $g): ?>
                <figure class="tile reveal" data-category="<?= e($g['category_slug']) ?>">
                    <img src="<?= e($g['image_url']) ?>" alt="<?= e($g['title']) ?>" loading="lazy">
                    <figcaption class="meta">
                        <span class="cat"><?= e($g['category_name']) ?></span>
                        <span class="ttl"><?= e($g['title']) ?></span>
                        <?php if ($g['stylist_name']): ?><span class="by">by <?= e($g['stylist_name']) ?></span><?php endif; ?>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php partial('cta', ['cta_title' => 'Like what you see?', 'cta_text' => 'Bring us a reference or let us design something for you. Either way, the result is on the wall above.']); ?>
