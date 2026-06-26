<?php /** Single outlet detail page. Vars: $outlet, $hours, $today, $services, $other_outlets */ ?>

<?php $hero_slide = !empty($hero_slides) ? $hero_slides[array_rand($hero_slides)] : null; ?>
<section class="page-hero">
    <?php if ($hero_slide): ?>
        <div class="page-hero-bg">
            <img src="<?= e(image($hero_slide['image_url'])) ?>" alt="">
        </div>
    <?php endif; ?>
    <div class="container">
        <a class="breadcrumb" href="<?= e(url('outlets')) ?>">← All locations</a>
        <?php if (!empty($outlet['tagline'])): ?>
            <p class="eyebrow" style="margin-top:32px"><?= e($outlet['tagline']) ?></p>
        <?php endif; ?>
        <h1 style="margin-top:<?= !empty($outlet['tagline']) ? '16px' : '40px' ?>"><?= e($outlet['name']) ?></h1>
        <p class="lede"><?= e($outlet['city']) ?></p>

        <?php
            $has_rating  = !empty($outlet['google_rating']);
            $has_today   = $today && !$today['is_closed'];
            $has_ladies  = !empty($outlet['has_ladies_room']);
            if ($has_rating || $has_today || $has_ladies):
        ?>
        <div class="outlet-stats-bar">
            <?php if ($has_rating): ?>
                <span class="outlet-stat">
                    <span class="outlet-stat-icon">★</span>
                    <?= e((string) $outlet['google_rating']) ?> Google
                </span>
            <?php endif; ?>
            <?php if ($has_today): ?>
                <span class="outlet-stat">
                    <i class="fa-regular fa-clock"></i>
                    Open today · <?= fmt_time($today['open_time']) ?>–<?= fmt_time($today['close_time']) ?>
                </span>
            <?php elseif ($today && $today['is_closed']): ?>
                <span class="outlet-stat outlet-stat--closed">
                    <i class="fa-regular fa-clock"></i> Closed today
                </span>
            <?php endif; ?>
            <?php if ($has_ladies): ?>
                <span class="outlet-stat">
                    <i class="fa-solid fa-venus"></i> Ladies room
                </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php /* ── 1. Info + photo ── */ ?>
<section class="section outlet-page-section">
    <div class="container">
        <div class="outlet-detail">

            <div class="outlet-detail-left">
                <div class="outlet-detail-media reveal">
                    <?php if (!empty($outlet['photo_url'])): ?>
                        <img src="<?= e(image($outlet['photo_url'])) ?>" alt="<?= e($outlet['name']) ?>">
                    <?php else: ?>
                        <div class="outlet-card-placeholder outlet-card-placeholder--lg"><i class="fa-solid fa-scissors"></i></div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($outlet['description'])): ?>
                <div class="outlet-desc-below reveal">
                    <span class="eyebrow">About this outlet</span>
                    <p><?= nl2br(e($outlet['description'])) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <div class="outlet-detail-info reveal" style="--d:.1s">

                <?php if (!empty($outlet['landmark'])): ?>
                <div class="outlet-info-block">
                    <span class="eyebrow">Landmark</span>
                    <p><?= e($outlet['landmark']) ?></p>
                </div>
                <?php endif; ?>

                <div class="outlet-info-block">
                    <span class="eyebrow">Address</span>
                    <p><?= e($outlet['address']) ?></p>
                    <?php if (!empty($outlet['gmaps_url'])): ?>
                        <a class="btn-text" href="<?= e($outlet['gmaps_url']) ?>" target="_blank" rel="noopener">Open in Google Maps <span aria-hidden="true">→</span></a>
                    <?php endif; ?>
                </div>

                <?php if (!empty($hours)): ?>
                <div class="outlet-info-block">
                    <span class="eyebrow">Opening Hours</span>
                    <table class="hours-table">
                        <?php
                        $today_order = (int) date('N');
                        foreach ($hours as $row):
                            $is_today = ((int) $row['day_order']) === $today_order;
                        ?>
                        <tr class="<?= $is_today ? 'is-today' : '' ?>">
                            <td class="hours-day"><?= e($row['day_name']) ?></td>
                            <td class="hours-time">
                                <?php if ($row['is_closed']): ?>
                                    <span class="hours-closed">Closed</span>
                                <?php else: ?>
                                    <?= fmt_time($row['open_time']) ?>–<?= fmt_time($row['close_time']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>

                <?php if (!empty($outlet['phone'])): ?>
                <div class="outlet-info-block">
                    <span class="eyebrow">Phone</span>
                    <p><a href="tel:<?= e(preg_replace('/\s/', '', $outlet['phone'])) ?>"><?= e($outlet['phone']) ?></a></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($outlet['has_ladies_room'])): ?>
                <div class="outlet-info-block">
                    <span class="eyebrow">Facilities</span>
                    <p><i class="fa-solid fa-venus" style="color:var(--accent);margin-right:6px"></i>Private ladies room available</p>
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

<?php /* ── 2. Google Map ── */ ?>
<?php
    $embed_url = null;
    if (!empty($outlet['lat']) && !empty($outlet['lng'])) {
        $embed_url = 'https://maps.google.com/maps?q=' . $outlet['lat'] . ',' . $outlet['lng'] . '&z=16&output=embed';
    } elseif (!empty($outlet['gmaps_url'])) {
        preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $outlet['gmaps_url'], $coords);
        if (!empty($coords)) {
            $embed_url = 'https://maps.google.com/maps?q=' . $coords[1] . ',' . $coords[2] . '&z=16&output=embed';
        }
    }
?>
<?php if ($embed_url): ?>
<section class="section--tight section--alt outlet-page-section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Location</span>
            <h2>Find us</h2>
        </div>
        <div class="outlet-map-layout reveal">
            <div class="outlet-map-embed">
                <iframe
                    src="<?= e($embed_url) ?>"
                    width="100%" height="100%" style="border:0"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="outlet-map-card">
                <?php if (!empty($outlet['address'])): ?>
                <div class="outlet-map-card-block">
                    <span class="eyebrow">Full address</span>
                    <p><?= e($outlet['address']) ?></p>
                </div>
                <?php endif; ?>
                <?php if (!empty($outlet['landmark'])): ?>
                <div class="outlet-map-card-block">
                    <p class="outlet-map-landmark">Near <?= e($outlet['landmark']) ?></p>
                </div>
                <?php endif; ?>
                <?php
                    $nav_url = null;
                    if (!empty($outlet['lat']) && !empty($outlet['lng'])) {
                        $nav_url = 'https://www.google.com/maps/dir/?api=1&destination=' . $outlet['lat'] . ',' . $outlet['lng'];
                    } elseif (!empty($outlet['gmaps_url'])) {
                        $nav_url = $outlet['gmaps_url'];
                    }
                ?>
                <?php if ($nav_url): ?>
                <a class="btn" href="<?= e($nav_url) ?>" target="_blank" rel="noopener">
                    Get directions →
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ── 3. Services & prices ── */ ?>
<?php if (!empty($services)): ?>
<section class="section section--alt outlet-page-section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Menu &amp; pricing</span>
            <h2>Services at <?= e($outlet['city']) ?></h2>
        </div>
        <?php foreach ($services as $category => $items): ?>
            <div class="menu-cat">
                <div class="menu-cat__head">
                    <h3><?= e($category) ?></h3>
                </div>
                <?php foreach ($items as $item): ?>
                <div class="menu-row">
                    <div class="nm"><?= e($item['name']) ?></div>
                    <div class="price"><?= price_label($item) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php /* ── 4. FAQs ── */ ?>
<?php if (!empty($faqs)): ?>
<section class="section outlet-page-section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Before you visit</span>
            <h2>Frequently asked questions</h2>
        </div>
        <div class="outlet-faq-list">
            <?php foreach ($faqs as $faq): ?>
            <details class="outlet-faq-item reveal">
                <summary class="outlet-faq-q"><?= e($faq['question']) ?></summary>
                <div class="outlet-faq-a"><p><?= nl2br(e($faq['answer'])) ?></p></div>
            </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php /* ── 5. Other outlets ── */ ?>
<?php if (!empty($other_outlets)): ?>
<section class="section outlet-page-section">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Our network</span>
            <h2>Other ÉCLAT locations</h2>
        </div>
        <div class="outlets-grid">
            <?php foreach ($other_outlets as $o): ?>
            <div class="outlet-card outlet-card--full reveal">
                <a class="outlet-card-img" href="<?= e(url('outlet/' . $o['slug'])) ?>">
                    <?php if (!empty($o['photo_url'])): ?>
                        <img src="<?= e(image($o['photo_url'])) ?>" alt="<?= e($o['name']) ?>" loading="lazy">
                    <?php else: ?>
                        <div class="outlet-card-placeholder"><i class="fa-solid fa-scissors"></i></div>
                    <?php endif; ?>
                </a>
                <div class="outlet-card-body">
                    <p class="outlet-card-city"><?= e($o['city']) ?></p>
                    <h3 class="outlet-card-name"><?= e($o['name']) ?></h3>
                    <p class="outlet-card-addr"><?= e($o['address']) ?></p>
                    <div class="outlet-card-actions">
                        <?php if (!empty($o['gmaps_url'])): ?>
                            <a class="outlet-action outlet-action--map" href="<?= e($o['gmaps_url']) ?>" target="_blank" rel="noopener" title="Google Maps"><i class="fa-solid fa-location-dot"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($o['whatsapp'])): ?>
                            <a class="outlet-action outlet-action--wa" href="https://wa.me/<?= e(preg_replace('/\D/', '', $o['whatsapp'])) ?>" target="_blank" rel="noopener" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <?php endif; ?>
                        <a class="outlet-card-link" href="<?= e(url('outlet/' . $o['slug'])) ?>">Outlet page →</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php partial('cta'); ?>
