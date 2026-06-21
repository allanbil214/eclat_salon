<?php /** Article page. Vars: $post $more */ ?>

<section class="article-hero">
    <div class="article-hero-bg">
        <?php if ($post['cover_url'] !== ''): ?><img src="<?= e(image($post['cover_url'])) ?>" alt="" aria-hidden="true"><?php endif; ?>
    </div>
    <div class="container narrow">
        <div class="breadcrumb">
            <a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>
            <a href="<?= e(url('blog')) ?>">Article</a><span class="sep">/</span><?= e($post['category']) ?>
        </div>
        <div class="article-meta">
            <?php if ($post['category'] !== ''): ?><span class="post-cat"><?= e($post['category']) ?></span><span class="dot">·</span><?php endif; ?>
            <time datetime="<?= e((string) $post['published_at']) ?>"><?= e(post_date($post['published_at'])) ?></time>
            <span class="dot">·</span><span><?= reading_time($post['body']) ?> min read</span>
        </div>
        <h1 class="article-title"><?= e($post['title']) ?></h1>
        <?php if ($post['author'] !== ''): ?><div class="article-byline">By <?= e($post['author']) ?></div><?php endif; ?>
    </div>
</section>

<section class="section article-section">
    <!-- Body is trusted admin HTML (Quill output) — rendered as-is. -->
    <div class="container narrow article-body reveal"><?= $post['body'] ?></div>
    <div class="container narrow article-back">
        <a class="btn-text" href="<?= e(url('blog')) ?>"><span aria-hidden="true">←</span> All articles</a>
    </div>
</section>

<?php partial('posts-strip', ['posts' => $more, 'eyebrow' => 'Keep reading', 'heading' => 'More from the studio', 'alt' => true]); ?>
<?php partial('cta'); ?>
