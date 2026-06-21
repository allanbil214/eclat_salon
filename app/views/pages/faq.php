<?php /** FAQ page. Vars: $faqs */ ?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/faq-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">Good to know</span>
        <h1>Questions, answered</h1>
        <p class="lede">Everything you might want to know before your visit — from booking and cancellations to keeping your colour fresh at home.</p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>FAQ</div>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if ($faqs): ?>
            <div class="faq-list reveal">
                <?php foreach ($faqs as $f): ?>
                    <div class="acc-item">
                        <button class="acc-trigger" type="button" aria-expanded="false">
                            <span><?= e($f['question']) ?></span>
                            <span class="ico" aria-hidden="true"></span>
                        </button>
                        <div class="acc-panel">
                            <div class="acc-panel__inner"><?= e($f['answer']) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="shop-note">No questions yet — check back soon.</p>
        <?php endif; ?>

        <div class="faq-help reveal">
            <h3>Still have a question?</h3>
            <p>We are happy to help — message us on WhatsApp or book in and ask your stylist.</p>
            <div class="faq-help-actions">
                <?php $wa = preg_replace('/\D+/', '', get_setting('whatsapp')); ?>
                <?php if ($wa !== ''): ?>
                    <a class="btn btn-primary" href="https://wa.me/<?= e($wa) ?>?text=<?= rawurlencode('Halo ÉCLAT! Saya ada pertanyaan.') ?>" target="_blank" rel="noopener">Ask on WhatsApp <span aria-hidden="true">→</span></a>
                <?php endif; ?>
                <a class="btn btn-ghost" href="<?= e(url('book')) ?>">Book an appointment</a>
            </div>
        </div>
    </div>
</section>
