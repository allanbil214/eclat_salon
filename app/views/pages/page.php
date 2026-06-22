<?php /** Static page. Vars: $page */ ?>

<section class="page-hero page-hero--short">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/cta/cta.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">ÉCLAT</span>
        <h1><?= e($page['title']) ?></h1>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span><?= e($page['title']) ?></div>
    </div>
</section>

<section class="section">
    <!-- Body is admin HTML (Quill output) — rendered as-is. -->
    <div class="container narrow page-body reveal"><?= $page['body'] ?></div>
    <?php if (!empty($page['updated_at'])): ?>
        <div class="container narrow page-updated">Last updated <?= e(date('j F Y', strtotime((string) $page['updated_at']))) ?></div>
    <?php endif; ?>
</section>
