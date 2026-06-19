<?php /** Team grid. Expects $members (array of team rows). */
$members = $members ?? []; ?>
<div class="grid grid-4">
    <?php foreach ($members as $i => $m): ?>
        <article class="team-card reveal" style="--d: <?= number_format($i * 0.06, 2) ?>s">
            <div class="photo">
                <img src="<?= e($m['photo_url']) ?>" alt="<?= e($m['name'] . ' — ' . $m['role']) ?>" loading="lazy">
                <?php if ($m['instagram']): ?>
                    <span class="ig"><?= e($m['instagram']) ?> <span aria-hidden="true">↗</span></span>
                <?php endif; ?>
            </div>
            <h3 class="name"><?= e($m['name']) ?></h3>
            <div class="role"><?= e($m['role']) ?></div>
            <p class="spec"><?= e($m['specialty']) ?></p>
        </article>
    <?php endforeach; ?>
</div>
