<?php /** Vars: $rows */ ?>
<div class="adm-head"><h1 class="adm-h1">Stats</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('stats/new')) ?>">+ New stat</a></div>
<p class="adm-note" style="margin-top:0;margin-bottom:18px">The number band on the home page (e.g. <strong>500+ happy clients</strong>).</p>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th>Label</th><th class="w-min">Displays as</th><th class="w-min">Status</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $st): ?>
        <tr>
            <td><strong><?= e($st['label']) ?></strong></td>
            <td class="adm-muted"><?= e($st['prefix'] . number_format((int) $st['value']) . $st['suffix']) ?></td>
            <td><?= $st['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-muted"><?= (int) $st['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('stats/edit?id=' . $st['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('stats/delete')) ?>" onsubmit="return confirm('Delete this stat?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $st['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No stats yet. <a href="<?= e(admin_url('stats/new')) ?>">Add the first one</a>.</p><?php endif; ?>
