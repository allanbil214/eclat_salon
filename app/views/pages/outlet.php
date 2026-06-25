<?php /** Single outlet page. Vars: $outlet */ ?>

<?php $hero_slide = !empty($hero_slides) ? $hero_slides[array_rand($hero_slides)] : null; ?>
<section class="page-hero">
    <?php if ($hero_slide): ?>
        <div class="page-hero-bg">
            <img src="<?= e(image($hero_slide['image_url'])) ?>" alt="">
        </div>
    <?php endif; ?>
    <div class="container">
        <div style="padding-top:clamp(40px,6vw,80px); padding-bottom: clamp(20px,3vw,40px)">
            <a class="btn-text" href="<?= e(url('outlets')) ?>" style="font-size:0.82rem;letter-spacing:.14em;text-transform:uppercase">← All locations</a>
            <h1 style="margin-top:22px"><?= e($outlet['name']) ?></h1>
            <p class="lede"><?= e($outlet['city']) ?></p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="outlet-detail">

            <div class="outlet-detail-media reveal">
                <?php if (!empty($outlet['photo_url'])): ?>
                    <img src="<?= e(image($outlet['photo_url'])) ?>" alt="<?= e($outlet['name']) ?>">
                <?php else: ?>
                    <div class="outlet-card-placeholder outlet-card-placeholder--lg"><i class="fa-solid fa-scissors"></i></div>
                <?php endif; ?>
            </div>

            <div class="outlet-detail-info reveal" style="--d:.1s">
                <div class="outlet-info-block">
                    <span class="eyebrow">Address</span>
                    <p><?= e($outlet['address']) ?></p>
                    <?php if (!empty($outlet['gmaps_url'])): ?>
                        <a class="btn-text" href="<?= e($outlet['gmaps_url']) ?>" target="_blank" rel="noopener">Open in Google Maps <span aria-hidden="true">→</span></a>
                    <?php endif; ?>
                </div>

                <?php if (!empty($outlet['phone'])): ?>
                <div class="outlet-info-block">
                    <span class="eyebrow">Phone</span>
                    <p><a href="tel:<?= e(preg_replace('/\s/', '', $outlet['phone'])) ?>"><?= e($outlet['phone']) ?></a></p>
                </div>
                <?php endif; ?>

                <div class="outlet-detail-ctas">
                    <?php if (!empty($outlet['whatsapp'])): ?>
                        <a class="btn btn-primary" href="https://wa.me/<?= e(preg_replace('/\D/', '', $outlet['whatsapp'])) ?>" target="_blank" rel="noopener">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp us
                        </a>
                    <?php endif; ?>
                    <a class="btn" href="<?= e(url('book')) ?>">Book appointment</a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php partial('cta'); ?>
