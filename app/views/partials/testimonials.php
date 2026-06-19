<?php /** Testimonials grid. Expects $items (array of testimonial rows). */
$items = $items ?? []; ?>
<div class="grid grid-3">
    <?php foreach ($items as $i => $t): ?>
        <figure class="quote-card reveal" style="--d: <?= number_format($i * 0.06, 2) ?>s">
            <div class="rate" aria-label="<?= (int) $t['rating'] ?> out of 5"><?= e(stars((int) $t['rating'])) ?></div>
            <blockquote>"<?= e($t['quote']) ?>"</blockquote>
            <figcaption class="who">
                <span class="nm"><?= e($t['author']) ?><?= $t['service'] ? ' · ' . e($t['service']) : '' ?></span>
                <span class="src"><?= e($t['source']) ?></span>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</div>
