<?php /** About page. Vars: $team $stats $values */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/about-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow"><?= e(get_setting('about_eyebrow')) ?></span>
        <h1>The atelier behind the chair</h1>
        <p class="lede"><?= e(get_setting('tagline')) ?> — and a sixteen-year obsession with getting it right.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>About</div>
    </div>
</section>

<section class="section">
    <div class="container story-grid">
        <div class="reveal">
            <span class="eyebrow">Our story</span>
            <h2 style="margin:22px 0 0.5em"><?= e(get_setting('about_title')) ?></h2>
            <p><?= e(get_setting('about_p1')) ?></p>
            <p style="margin-top:1.1em"><?= e(get_setting('about_p2')) ?></p>
            <a class="btn-text" href="<?= e(url('book')) ?>" style="margin-top:32px">Book with us <span class="arrow" aria-hidden="true">→</span></a>
        </div>
        <div class="stack reveal" style="--d:.1s">
            <img class="tall" src="<?= e(url('assets/img/about/story-1.jpg')) ?>" alt="The ÉCLAT studio" loading="lazy">
            <img class="wide" src="<?= e(url('assets/img/about/story-2.jpg')) ?>" alt="A stylist at work" loading="lazy">
        </div>
    </div>
</section>

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

<section class="section section--alt">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow eyebrow--center">How we work</span>
            <h2 style="margin-top:22px">Three things we never compromise on</h2>
        </div>
        <div class="values-grid">
            <?php foreach ($values as $i => $v): ?>
                <div class="value reveal" style="--d:<?= number_format($i * 0.08, 2) ?>s">
                    <div class="n"><?= sprintf('%02d', $i + 1) ?></div>
                    <h4><?= e($v['title']) ?></h4>
                    <p><?= e($v['text']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="eyebrow eyebrow--center">Meet the team</span>
            <h2 style="margin-top:22px">Eight pairs of expert hands</h2>
            <p class="lede">Every one of our stylists has earned their chair. Find the right fit for your hair.</p>
        </div>
        <?php partial('team-grid', ['members' => $team]); ?>
    </div>
</section>

<?php partial('cta', ['cta_title' => 'Come and sit in our chair.', 'cta_text' => 'New guests are always welcome. Tell us about your hair and we will pair you with the right specialist.']); ?>
