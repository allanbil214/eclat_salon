<?php /** Vars: $b */ ?>
<div class="adm-head">
    <div><h1 class="adm-h1">Booking request</h1><p class="adm-muted"><?= e(date('l, j F Y · H:i', strtotime((string) $b['created_at']))) ?></p></div>
    <a class="adm-btn" href="<?= e(admin_url('bookings')) ?>">← All requests</a>
</div>
<div class="adm-panel" style="max-width:640px">
    <dl class="adm-dl">
        <dt>Name</dt><dd><?= e($b['name']) ?: '—' ?></dd>
        <dt>Phone</dt><dd><?= e($b['phone']) ?: '—' ?></dd>
        <dt>Email</dt><dd><?= e($b['email']) ?: '—' ?></dd>
        <dt>Outlet</dt><dd><?= e($b['outlet_name'] ?? '') ?: '—' ?></dd>
        <dt>Service</dt><dd><?= e($b['service_name'] ?? '') ?: '—' ?></dd>
        <dt>Preferred</dt><dd><?= $b['preferred_date'] ? e(date('l, j F Y', strtotime((string) $b['preferred_date']))) : '—' ?></dd>
        <?php if ($b['message']): ?><dt>Message</dt><dd><?= nl2br(e($b['message'])) ?></dd><?php endif; ?>
    </dl>
    <div class="adm-statusbar">
        <?php $wa = whatsapp_booking_reply_url($b); if ($wa): ?>
            <a class="adm-btn adm-btn--wa" href="<?= e($wa) ?>" target="_blank" rel="noopener">Reply on WhatsApp ↗</a>
        <?php else: ?><span></span><?php endif; ?>
        <form method="post" action="<?= e(admin_url('bookings/delete')) ?>" onsubmit="return confirm('Delete this booking request?');">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>">
            <button type="submit" class="adm-link-danger">Delete request</button>
        </form>
    </div>
</div>
