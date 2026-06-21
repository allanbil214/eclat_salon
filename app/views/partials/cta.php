<?php /** Book CTA banner. Optional $cta_title, $cta_text. */
$cta_title = $cta_title ?? 'Your chair is waiting.';
$cta_text  = $cta_text  ?? 'Tell us what you have been picturing. We will take it from there.'; ?>
<section class="section cta-section">
    <div class="container">
        <div class="cta-banner reveal">
            <div class="bg"><img src="<?= e(url('assets/img/cta/cta.jpg')) ?>" alt="" aria-hidden="true" loading="lazy"></div>
            <div class="inner">
                <span class="eyebrow eyebrow--center">Book an appointment</span>
                <h2><?= e($cta_title) ?></h2>
                <p><?= e($cta_text) ?></p>
                <a class="btn btn-primary" href="<?= e(url('book')) ?>">Request your appointment <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>
</section>
