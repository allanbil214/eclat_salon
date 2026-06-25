<?php
/**
 * Outlets carousel strip.
 * Expects: $outlets (array), optional $eyebrow, $heading, $alt (bool)
 */
$eyebrow = $eyebrow ?? 'Find us';
$heading = $heading ?? 'Our Locations';
$alt     = $alt ?? false;
if (empty($outlets)) return;
$has_many = count($outlets) > 3;
?>
<section class="section<?= $alt ? ' section--alt' : '' ?>">
    <div class="container">
        <div class="section-head split">
            <div>
                <span class="eyebrow"><?= e($eyebrow) ?></span>
                <h2 style="margin-top:22px"><?= e($heading) ?></h2>
            </div>
            <a class="btn-text" href="<?= e(url('outlets')) ?>">All locations <span class="arrow" aria-hidden="true">→</span></a>
        </div>
    </div>

    <div class="outlets-carousel-wrap">
        <div class="outlets-track" data-outlets-track>
            <?php foreach ($outlets as $o): ?>
            <article class="outlet-card reveal">
                <a class="outlet-card-img" href="<?= e(url('outlet/' . $o['slug'])) ?>">
                    <?php if (!empty($o['photo_url'])): ?>
                        <img src="<?= e(image($o['photo_url'])) ?>" alt="<?= e($o['name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="outlet-card-placeholder"><i class="fa-solid fa-scissors"></i></div>
                    <?php endif; ?>
                </a>
                <div class="outlet-card-body">
                    <h3 class="outlet-card-name"><?= e($o['name']) ?></h3>
                    <p class="outlet-card-city"><?= e($o['city']) ?></p>
                    <p class="outlet-card-addr"><?= e($o['address']) ?></p>
                    <div class="outlet-card-actions">
                        <?php if (!empty($o['gmaps_url'])): ?>
                            <a class="outlet-action outlet-action--map" href="<?= e($o['gmaps_url']) ?>" target="_blank" rel="noopener" aria-label="Open in Google Maps">
                                <i class="fa-solid fa-location-dot"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($o['whatsapp'])): ?>
                            <a class="outlet-action outlet-action--wa" href="https://wa.me/<?= e(preg_replace('/\D/', '', $o['whatsapp'])) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        <?php endif; ?>
                        <a class="outlet-card-link" href="<?= e(url('outlet/' . $o['slug'])) ?>">Outlet page <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <?php if ($has_many): ?>
        <button class="outlets-nav outlets-prev" type="button" aria-label="Previous" data-outlets-prev>‹</button>
        <button class="outlets-nav outlets-next" type="button" aria-label="Next" data-outlets-next>›</button>
        <?php endif; ?>
    </div>
</section>
