<?php /** Vars: $outlet, $rows */ ?>
<div class="adm-head">
    <div>
        <h1 class="adm-h1">FAQs — <?= e($outlet['name']) ?></h1>
        <p class="adm-muted" style="margin:4px 0 0">Location-specific questions shown on the outlet detail page.</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
        <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('outlets/faq/new?outlet_id=' . (int) $outlet['id'])) ?>">+ Add FAQ</a>
        <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">← Outlets</a>
    </div>
</div>

<?php if ($rows): ?>
<table class="adm-table">
    <thead>
        <tr>
            <th>Question</th>
            <th>Answer</th>
            <th class="w-min">Order</th>
            <th class="w-min">Active</th>
            <th class="w-min"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><strong><?= e($r['question']) ?></strong></td>
            <td class="adm-muted adm-clip"><?= e($r['answer']) ?></td>
            <td class="adm-muted"><?= (int) $r['sort_order'] ?></td>
            <td class="adm-muted"><?= $r['is_active'] ? '✓' : '—' ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('outlets/faq/edit?outlet_id=' . (int) $outlet['id'] . '&id=' . (int) $r['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('outlets/faq/delete')) ?>" onsubmit="return confirm('Delete this FAQ?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button type="submit" class="adm-link-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p class="adm-empty">No FAQs yet for this outlet. <a href="<?= e(admin_url('outlets/faq/new?outlet_id=' . (int) $outlet['id'])) ?>">Add the first one</a>.</p>
<?php endif; ?>
