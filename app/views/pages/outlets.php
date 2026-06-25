<?php /** Outlets listing page. Vars: $outlets */ ?>

<section class="section solid-hero">
    <div class="container">
        <div class="section-head center" style="padding-top: clamp(40px,6vw,80px)">
            <span class="eyebrow eyebrow--center">Find us</span>
            <h1 style="margin-top:22px">Our Locations</h1>
            <p class="lede" style="max-width:46ch;margin-inline:auto">Every ÉCLAT outlet carries the same obsessive standard. Choose the one closest to you.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (!empty($outlets)): ?>
        <div class="outlets-grid">
            <?php foreach ($outlets as $o): ?>
            <article class="outlet-card outlet-card--full reveal">
                <a class="outlet-card-img" href="<?= e(url('outlet/' . $o['slug'])) ?>">
                    <?php if (!empty($o['photo_url'])): ?>
                        <img src="<?= e(image($o['photo_url'])) ?>" alt="<?= e($o['name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="outlet-card-placeholder"><i class="fa-solid fa-scissors"></i></div>
                    <?php endif; ?>
                </a>
                <div class="outlet-card-body">
                    <h2 class="outlet-card-name"><?= e($o['name']) ?></h2>
                    <p class="outlet-card-city"><?= e($o['city']) ?></p>
                    <p class="outlet-card-addr"><?= e($o['address']) ?></p>
                    <?php if (!empty($o['phone'])): ?>
                    <p class="outlet-card-phone"><a href="tel:<?= e(preg_replace('/\s/', '', $o['phone'])) ?>"><?= e($o['phone']) ?></a></p>
                    <?php endif; ?>
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
                        <a class="btn btn-primary" href="<?= e(url('outlet/' . $o['slug'])) ?>">View outlet</a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p class="adm-empty" style="text-align:center;padding:60px 0">No locations found.</p>
        <?php endif; ?>
    </div>
</section>

<?php partial('cta'); ?>
