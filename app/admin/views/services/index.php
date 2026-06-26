<?php /** Vars: $rows, $cats */
function svc_price($s) {
    $pf = $s['price_from']; $pt = $s['price_to'];
    if ($pf !== null && $pt !== null) return money((float) $pf) . ' – ' . money((float) $pt);
    if ($pf !== null) return 'from ' . money((float) $pf);
    return '—';
}
?>
<div class="adm-head">
    <h1 class="adm-h1">Services</h1>
    <div class="adm-head-actions">
        <a class="adm-btn" href="<?= e(admin_url('services/categories')) ?>">Categories</a>
        <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('services/new')) ?>"><i class="fa-solid fa-plus"></i> New service</a>
    </div>
</div>
<div class="adm-tabs"><a class="adm-tab on" href="<?= e(admin_url('services')) ?>">Services <span><?= count($rows) ?></span></a><a class="adm-tab" href="<?= e(admin_url('services/categories')) ?>">Categories <span><?= count($cats) ?></span></a></div>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th>Service</th><th class="w-min">Category</th><th>Price</th><th class="w-min">Duration</th><th class="w-min">Status</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $s): ?>
        <tr>
            <td><strong><?= e($s['name']) ?></strong><?php if ($s['is_featured']): ?> <span class="adm-badge st-new">Featured</span><?php endif; ?><div class="adm-muted adm-clip"><?= e($s['description']) ?></div></td>
            <td class="adm-muted"><?= e($s['category_name']) ?></td>
            <td class="adm-muted"><?= e(svc_price($s)) ?></td>
            <td class="adm-muted"><?= $s['duration_min'] ? (int) $s['duration_min'] . ' min' : '—' ?></td>
            <td><?= $s['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('services/edit?id=' . $s['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="post" action="<?= e(admin_url('services/delete')) ?>" onsubmit="return confirm('Delete this service?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $s['id'] ?>"><button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No services yet. <a href="<?= e(admin_url('services/new')) ?>">Add the first one</a>.</p><?php endif; ?>
