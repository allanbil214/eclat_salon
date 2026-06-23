<?php /** Vars: $cats */ ?>
<div class="adm-head"><h1 class="adm-h1">Service categories</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('services/categories/new')) ?>">+ New category</a></div>
<div class="adm-tabs"><a class="adm-tab" href="<?= e(admin_url('services')) ?>">Services</a><a class="adm-tab on" href="<?= e(admin_url('services/categories')) ?>">Categories <span><?= count($cats) ?></span></a></div>
<?php if ($cats): ?>
<table class="adm-table">
    <thead><tr><th>Name</th><th>Blurb</th><th class="w-min">Services</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($cats as $c): ?>
        <tr>
            <td><strong><?= e($c['name']) ?></strong><div class="adm-muted"><?= e($c['slug']) ?></div></td>
            <td class="adm-muted adm-clip"><?= e($c['blurb']) ?></td>
            <td class="adm-muted"><?= (int) $c['item_count'] ?></td>
            <td class="adm-muted"><?= (int) $c['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('services/categories/edit?id=' . $c['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('services/categories/delete')) ?>" onsubmit="return confirm('Delete this category AND its <?= (int) $c['item_count'] ?> service(s)?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $c['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No categories yet. <a href="<?= e(admin_url('services/categories/new')) ?>">Add the first one</a>.</p><?php endif; ?>
