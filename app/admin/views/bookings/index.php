<?php /** Vars: $rows */ ?>
<div class="adm-head"><h1 class="adm-h1">Booking requests</h1></div>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th>Name</th><th class="w-min">Phone</th><th class="w-min">Service</th><th class="w-min">Preferred date</th><th class="w-min">Received</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $b): ?>
        <tr>
            <td><strong><?= e($b['name']) ?></strong></td>
            <td class="adm-muted"><?= e($b['phone']) ?: '—' ?></td>
            <td class="adm-muted"><?= e($b['service_name'] ?? '') ?: '—' ?></td>
            <td class="adm-muted"><?= $b['preferred_date'] ? e(date('j M Y', strtotime((string) $b['preferred_date']))) : '—' ?></td>
            <td class="adm-muted"><?= e(date('j M Y', strtotime((string) $b['created_at']))) ?></td>
            <td class="adm-row-actions"><a href="<?= e(admin_url('bookings/view?id=' . $b['id'])) ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No booking requests yet.</p><?php endif; ?>
