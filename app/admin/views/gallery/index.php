<?php /** Vars: $items, $cats */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Gallery</h1>
    <div class="adm-head-actions">
        <a class="adm-btn" href="<?= e(admin_url('gallery/categories')) ?>">Categories</a>
        <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('gallery/new')) ?>"><i class="fa-solid fa-plus"></i> New photo</a>
    </div>
</div>
<div class="adm-tabs"><a class="adm-tab on" href="<?= e(admin_url('gallery')) ?>">Photos <span><?= count($items) ?></span></a><a class="adm-tab" href="<?= e(admin_url('gallery/categories')) ?>">Categories <span><?= count($cats) ?></span></a></div>
<?php if ($items): ?>
<table class="adm-table">
    <thead><tr><th class="w-min"></th><th>Title</th><th class="w-min">Category</th><th class="w-min">Type</th><th class="w-min">Featured</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($items as $g): ?>
        <tr>
            <td><div class="adm-thumb"><?php if ($g['image_url']): ?><img src="<?= e(image($g['image_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td><strong><?= e($g['title']) ?: '<span class="adm-muted">(untitled)</span>' ?></strong><?php if ($g['stylist_name']): ?><div class="adm-muted">by <?= e($g['stylist_name']) ?></div><?php endif; ?></td>
            <td class="adm-muted"><?= e($g['category_name']) ?></td>
            <td><?= !empty($g['before_image_url']) ? '<span class="adm-badge st-new">Before/After</span>' : '<span class="adm-badge off">Single</span>' ?></td>
            <td><?= $g['is_featured'] ? '<span class="adm-badge on">Yes</span>' : '<span class="adm-muted">—</span>' ?></td>
            <td class="adm-muted"><?= (int) $g['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('gallery/edit?id=' . $g['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="post" action="<?= e(admin_url('gallery/delete')) ?>" onsubmit="return confirm('Delete this photo?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $g['id'] ?>"><button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No photos yet. <a href="<?= e(admin_url('gallery/new')) ?>">Add the first one</a>.</p><?php endif; ?>
