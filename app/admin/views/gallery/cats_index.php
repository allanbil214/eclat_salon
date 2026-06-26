<?php /** Vars: $cats */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Gallery categories</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('gallery/categories/new')) ?>"><i class="fa-solid fa-plus"></i> New category</a>
</div>
<div class="adm-tabs"><a class="adm-tab" href="<?= e(admin_url('gallery')) ?>">Photos</a><a class="adm-tab on" href="<?= e(admin_url('gallery/categories')) ?>">Categories <span><?= count($cats) ?></span></a></div>
<?php if ($cats): ?>
<table class="adm-table">
    <thead><tr><th>Name</th><th class="w-min">Slug</th><th class="w-min">Photos</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($cats as $c): ?>
        <tr>
            <td><strong><?= e($c['name']) ?></strong></td>
            <td class="adm-muted"><?= e($c['slug']) ?></td>
            <td class="adm-muted"><?= (int) $c['item_count'] ?></td>
            <td class="adm-muted"><?= (int) $c['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('gallery/categories/edit?id=' . $c['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="post" action="<?= e(admin_url('gallery/categories/delete')) ?>" onsubmit="return confirm('Delete this category AND its <?= (int) $c['item_count'] ?> photo(s)?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $c['id'] ?>"><button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No categories yet. <a href="<?= e(admin_url('gallery/categories/new')) ?>">Add the first one</a>.</p><?php endif; ?>
