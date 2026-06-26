<?php
/**
 * Shared location map embed — used on home and about pages.
 * Shows the studio's global lat/lng (from settings) with address + directions.
 *
 * Optional vars (all fall back to settings):
 *   $eyebrow   string  default 'Location'
 *   $heading   string  default 'Find us'
 *   $section_class  string  extra class on <section>
 */
$eyebrow       = $eyebrow       ?? 'Location';
$heading       = $heading       ?? 'Find us';
$section_class = $section_class ?? '';

$lat     = get_setting('latitude');
$lng     = get_setting('longitude');
$address = get_setting('address');
$map_url = get_setting('map_url');
$phone   = get_setting('phone');

// Build embed URL — prefer lat/lng, fall back to extracting from map_url.
$embed_url = null;
if (!empty($lat) && !empty($lng)) {
    $embed_url = 'https://maps.google.com/maps?q=' . urlencode($lat) . ',' . urlencode($lng) . '&z=16&output=embed';
} elseif (!empty($map_url)) {
    preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $map_url, $coords);
    if (!empty($coords)) {
        $embed_url = 'https://maps.google.com/maps?q=' . $coords[1] . ',' . $coords[2] . '&z=16&output=embed';
    }
}

if (!$embed_url) return; // nothing to show

// Directions URL — deep-link to navigation.
$nav_url = (!empty($lat) && !empty($lng))
    ? 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($lat) . ',' . urlencode($lng)
    : $map_url;
?>
<section class="section--tight section--alt<?= $section_class ? ' ' . e($section_class) : '' ?>" style="padding-bottom:10px; padding-top:50px">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow"><?= e($eyebrow) ?></span>
            <h2><?= e($heading) ?></h2>
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
                <?php if (!empty($address)): ?>
                <div class="outlet-map-card-block">
                    <span class="eyebrow">Address</span>
                    <p><?= nl2br(e($address)) ?></p>
                </div>
                <?php endif; ?>
                <?php if (!empty($phone)): ?>
                <div class="outlet-map-card-block">
                    <span class="eyebrow">Phone</span>
                    <p><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>"><?= e($phone) ?></a></p>
                </div>
                <?php endif; ?>
                <?php if ($nav_url): ?>
                <a class="btn" href="<?= e($nav_url) ?>" target="_blank" rel="noopener">
                    Get directions →
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
