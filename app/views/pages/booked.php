<?php /** Booked confirmation page. Vars: $wa_url $name */
$first = trim(explode(' ', (string) $name)[0] ?? '');
?>
<section class="booked">
    <div class="container narrow booked-inner reveal">
        <div class="booked-check" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
        </div>

        <span class="eyebrow eyebrow--center">Appointment requested</span>
        <h1>You're booked in<?= $first !== '' ? ', ' . e($first) : '' ?>.</h1>
        <p class="lede">We've saved your request. We're opening WhatsApp so you can confirm the details with the studio — it only takes a tap.</p>

        <div class="booked-countdown" data-wa="<?= e($wa_url) ?>">
            Opening WhatsApp in <span class="secs" data-count-secs>5</span>s…
        </div>

        <div class="booked-actions">
            <a class="btn btn-primary" href="<?= e($wa_url) ?>" target="_blank" rel="noopener">Open WhatsApp now <span aria-hidden="true">→</span></a>
            <a class="btn-text" href="<?= e(url('')) ?>">Back to home</a>
        </div>

        <p class="booked-note">If WhatsApp doesn't open on its own, just tap the button above.</p>
    </div>
</section>
