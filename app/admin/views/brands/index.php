<?php /** Vars: $rows */ ?>
<div class="adm-head"><h1 class="adm-h1">Brands</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('brands/new')) ?>"><i class="fa-solid fa-plus"></i> New brand</a></div>
<p class="adm-note" style="margin-top:0;margin-bottom:18px">These appear in the brand marquee. Add a logo to show the logo instead of the name; add a website to make it clickable.</p>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th class="w-min"></th><th>Name</th><th>Website</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $b): ?>
        <tr>
            <td><div class="adm-thumb adm-thumb--contain"><?php if (!empty($b['logo_url'])): ?><img src="<?= e(image($b['logo_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td><strong><?= e($b['name']) ?></strong></td>
            <td class="adm-muted"><?= $b['website_url'] ? e($b['website_url']) : '—' ?></td>
            <td class="adm-muted"><?= (int) $b['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('brands/edit?id=' . $b['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                <form method="post" action="<?= e(admin_url('brands/delete')) ?>" onsubmit="return confirm('Delete this brand?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $b['id'] ?>"><button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No brands yet. <a href="<?= e(admin_url('brands/new')) ?>">Add the first one</a>.</p><?php endif; ?>
