<?php /** Order confirmation. Vars: $ref $name $total $items $wa_url */
$first = trim(explode(' ', (string) $name)[0] ?? '');
?>
<div data-clear-cart hidden></div>

<section class="booked ordered">
    <div class="container narrow booked-inner reveal">
        <div class="booked-check" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>

        <span class="eyebrow eyebrow--center">Order received</span>
        <h1>Thank you<?= $first !== '' ? ', ' . e($first) : '' ?>.</h1>
        <p class="lede">We've saved your order. We're opening WhatsApp so you can confirm it with the studio — it only takes a tap.</p>

        <div class="order-ref">Order reference <strong><?= e($ref) ?></strong></div>

        <div class="order-recap">
            <?php foreach ($items as $it): ?>
                <div class="recap-row">
                    <span><?= e(trim($it['brand'] . ' ' . $it['product_name'])) ?> <em>×<?= (int) $it['qty'] ?></em></span>
                    <span><?= e(money((float) $it['line_total'])) ?></span>
                </div>
            <?php endforeach; ?>
            <div class="recap-row recap-total"><span>Total</span><span><?= e(money((float) $total)) ?></span></div>
        </div>

        <div class="booked-countdown" data-wa="<?= e($wa_url) ?>">
            Opening WhatsApp in <span class="secs" data-count-secs>5</span>s…
        </div>

        <div class="booked-actions">
            <a class="btn btn-primary" href="<?= e($wa_url) ?>" target="_blank" rel="noopener">Open WhatsApp now <span aria-hidden="true">→</span></a>
            <a class="btn-text" href="<?= e(url('shop')) ?>">Back to shop</a>
        </div>

        <p class="booked-note">If WhatsApp doesn't open on its own, just tap the button above.</p>
    </div>
</section>
