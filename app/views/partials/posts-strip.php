<?php /** Article strip. Expects $posts; optional $eyebrow, $heading, $alt. */
$eyebrow = $eyebrow ?? 'Article';
$heading = $heading ?? 'Tips, trends & transformations';
$alt     = $alt ?? false;
if (empty($posts)) return;
?>
<section class="section<?= $alt ? ' section--alt' : '' ?>">
    <div class="container">
        <div class="section-head split">
            <div><span class="eyebrow"><?= e($eyebrow) ?></span><h2 style="margin-top:22px"><?= e($heading) ?></h2></div>
            <a class="btn-text" href="<?= e(url('blog')) ?>">All articles <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="post-grid post-grid--3">
            <?php foreach ($posts as $post) partial('post-card', ['post' => $post]); ?>
        </div>
    </div>
</section>
