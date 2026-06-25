<?php /** Vars: $rows */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Outlets</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('outlets/new')) ?>">+ New outlet</a>
</div>
<p class="adm-note" style="margin-top:0;margin-bottom:18px">These appear in the "Our Locations" carousel on the homepage and on the /outlets listing page.</p>

<?php if ($rows): ?>
<table class="adm-table">
    <thead>
        <tr>
            <th class="w-min"></th>
            <th>Name</th>
            <th>City</th>
            <th>Phone</th>
            <th class="w-min">Rating</th>
            <th class="w-min">Active</th>
            <th class="w-min">Order</th>
            <th class="w-min"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $o): ?>
        <tr>
            <td>
                <div class="adm-thumb">
                    <?php if (!empty($o['photo_url'])): ?>
                        <img src="<?= e(image($o['photo_url'])) ?>" alt="">
                    <?php endif; ?>
                </div>
            </td>
            <td><strong><?= e($o['name']) ?></strong><br><small class="adm-muted">/outlet/<?= e($o['slug']) ?></small></td>
            <td class="adm-muted"><?= e($o['city']) ?: '—' ?></td>
            <td class="adm-muted"><?= e($o['phone']) ?: '—' ?></td>
            <td class="adm-muted"><?= $o['google_rating'] !== null ? '⭐ ' . number_format((float)$o['google_rating'], 1) : '—' ?></td>
            <td class="adm-muted"><?= $o['is_active'] ? '✓' : '—' ?></td>
            <td class="adm-muted"><?= (int) $o['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('outlets/edit?id=' . $o['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('outlets/delete')) ?>" onsubmit="return confirm('Delete this outlet?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $o['id'] ?>">
                    <button type="submit" class="adm-link-danger">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p class="adm-empty">No outlets yet. <a href="<?= e(admin_url('outlets/new')) ?>">Add the first one</a>.</p>
<?php endif; ?>
