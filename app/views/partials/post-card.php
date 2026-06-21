<?php /** A single article card. Expects $post. */ ?>
<article class="post-card reveal" data-category="<?= e($post['category']) ?>">
    <a class="post-cover" href="<?= e(url('blog/' . $post['slug'])) ?>">
        <img src="<?= e(image($post['cover_url'])) ?>" alt="<?= e($post['title']) ?>" loading="lazy">
    </a>
    <div class="post-body">
        <div class="post-meta">
            <?php if ($post['category'] !== ''): ?><span class="post-cat"><?= e($post['category']) ?></span><span class="dot">·</span><?php endif; ?>
            <time datetime="<?= e((string) $post['published_at']) ?>"><?= e(post_date($post['published_at'])) ?></time>
        </div>
        <h3 class="post-title"><a href="<?= e(url('blog/' . $post['slug'])) ?>"><?= e($post['title']) ?></a></h3>
        <p class="post-excerpt"><?= e($post['excerpt']) ?></p>
        <div class="post-foot">
            <?php if ($post['author'] !== ''): ?><span>By <?= e($post['author']) ?></span><span class="dot">·</span><?php endif; ?>
            <span><?= reading_time($post['body']) ?> min read</span>
        </div>
    </div>
</article>
