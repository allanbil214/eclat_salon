<?php /** Vars: $faqs */ ?>
<div class="adm-head">
    <h1 class="adm-h1">FAQ</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('faq/new')) ?>">+ New question</a>
</div>
<?php if ($faqs): ?>
<table class="adm-table">
    <thead><tr><th class="w-min">Order</th><th>Question</th><th class="w-min">Status</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($faqs as $f): ?>
        <tr>
            <td class="adm-muted"><?= (int) $f['sort_order'] ?></td>
            <td>
                <strong><?= e($f['question']) ?></strong>
                <div class="adm-muted adm-clip"><?= e($f['answer']) ?></div>
            </td>
            <td><?= $f['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('faq/edit?id=' . $f['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('faq/delete')) ?>" onsubmit="return confirm('Delete this FAQ?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $f['id'] ?>">
                    <button type="submit" class="adm-link-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p class="adm-empty">No questions yet. <a href="<?= e(admin_url('faq/new')) ?>">Add the first one</a>.</p>
<?php endif; ?>
