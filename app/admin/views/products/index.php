<?php /** Vars: $products */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Products</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('products/new')) ?>">+ New product</a>
</div>
<?php if ($products): ?>
<table class="adm-table">
    <thead><tr><th class="w-min"></th><th>Product</th><th>Price</th><th class="w-min">Stock</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($products as $p): ?>
        <tr>
            <td><div class="adm-thumb"><?php if ($p['image_url']): ?><img src="<?= e(image($p['image_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td><strong><?= e($p['name']) ?></strong><div class="adm-muted"><?= e($p['brand']) ?></div></td>
            <td><?= $p['price'] !== null ? e(money((float) $p['price'])) : '—' ?></td>
            <td><?= $p['in_stock'] ? '<span class="adm-badge on">In stock</span>' : '<span class="adm-badge off">Out</span>' ?></td>
            <td class="adm-muted"><?= (int) $p['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('products/edit?id=' . $p['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('products/delete')) ?>" onsubmit="return confirm('Delete this product?');">
                    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
                    <button type="submit" class="adm-link-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p class="adm-empty">No products yet. <a href="<?= e(admin_url('products/new')) ?>">Add the first one</a>.</p>
<?php endif; ?>
