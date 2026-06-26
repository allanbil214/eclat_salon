<?php /** Vars: $items */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Hero Slides</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('hero-slides/new')) ?>"><i class="fa-solid fa-plus"></i> New slide</a>
</div>
<p class="adm-note" style="margin-bottom:20px">Images cross-fade on the homepage hero every 5–6 seconds. Drag to reorder — or use the sort order field. Only <strong>active</strong> slides are shown publicly.</p>
<?php if ($items): ?>
<table class="adm-table">
    <thead>
        <tr>
            <th class="w-min"></th>
            <th>Image</th>
            <th class="w-min">Active</th>
            <th class="w-min">Order</th>
            <th class="w-min"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $s): ?>
        <tr>
            <td><div class="adm-thumb"><?php if ($s['image_url']): ?><img src="<?= e(image($s['image_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td class="adm-muted"><?= e($s['image_url']) ?></td>
            <td><?= $s['active'] ? '<span class="adm-badge on">Yes</span>' : '<span class="adm-badge off">No</span>' ?></td>
            <td class="adm-muted"><?= (int) $s['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('hero-slides/edit?id=' . $s['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="post" action="<?= e(admin_url('hero-slides/delete')) ?>" onsubmit="return confirm('Delete this slide?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
                    <button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p class="adm-empty">No slides yet. <a href="<?= e(admin_url('hero-slides/new')) ?>">Add the first one</a>.</p>
<?php endif; ?>
