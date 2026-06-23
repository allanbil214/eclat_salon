<?php /** Vars: $pages */ ?>
<div class="adm-head"><h1 class="adm-h1">Pages</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('pages/new')) ?>">+ New page</a></div>
<?php if ($pages): ?>
<table class="adm-table">
    <thead><tr><th>Title</th><th class="w-min">URL</th><th class="w-min">Status</th><th class="w-min">Updated</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($pages as $pg): ?>
        <tr>
            <td><strong><?= e($pg['title']) ?></strong></td>
            <td class="adm-muted">/<?= e($pg['slug']) ?></td>
            <td><?= $pg['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-muted"><?= $pg['updated_at'] ? e(date('j M Y', strtotime((string) $pg['updated_at']))) : '—' ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('pages/edit?id=' . $pg['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('pages/delete')) ?>" onsubmit="return confirm('Delete this page?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $pg['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No pages yet.</p><?php endif; ?>
