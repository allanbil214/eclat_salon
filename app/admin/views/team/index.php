<?php /** Vars: $rows */ ?>
<div class="adm-head"><h1 class="adm-h1">Team</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('team/new')) ?>">+ New team member</a></div>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th class="w-min"></th><th>Name</th><th class="w-min">Role</th><th>Specialty</th><th class="w-min">Status</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $m): ?>
        <tr>
            <td><div class="adm-thumb"><?php if ($m['photo_url']): ?><img src="<?= e(image($m['photo_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td><strong><?= e($m['name']) ?></strong><?php if ($m['is_owner']): ?> <span class="adm-badge st-new">Owner</span><?php endif; ?></td>
            <td class="adm-muted"><?= e($m['role']) ?></td>
            <td class="adm-muted adm-clip"><?= e($m['specialty']) ?></td>
            <td><?= $m['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-muted"><?= (int) $m['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('team/edit?id=' . $m['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('team/delete')) ?>" onsubmit="return confirm('Delete this team member?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $m['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No team members yet. <a href="<?= e(admin_url('team/new')) ?>">Add the first one</a>.</p><?php endif; ?>
