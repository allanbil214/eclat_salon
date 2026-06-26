<?php /** Vars: $rows */ ?>
<div class="adm-head">
    <h1 class="adm-h1">Outlets</h1>
    <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('outlets/new')) ?>"><i class="fa-solid fa-plus"></i> New outlet</a>
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
            <td class="adm-muted"><?= $o['google_rating'] !== null ? '<i class="fa-solid fa-star" style="color:#f5a623;font-size:11px"></i> ' . number_format((float)$o['google_rating'], 1) : '—' ?></td>
            <td><?= $o['is_active']
                ? '<i class="fa-solid fa-circle-check" style="color:var(--a-ok);font-size:15px" title="Active"></i>'
                : '<i class="fa-solid fa-circle-minus" style="color:var(--a-text3);font-size:15px" title="Inactive"></i>' ?></td>
            <td class="adm-muted"><?= (int) $o['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a class="adm-btn adm-btn--sm" href="<?= e(admin_url('outlets/edit?id=' . $o['id'])) ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>

                <div class="adm-dropdown" style="position:relative">
                    <button type="button" class="adm-btn adm-btn--sm adm-dropdown-toggle">Manage <i class="fa-solid fa-chevron-down" style="font-size:10px"></i></button>
                    <div class="adm-dropdown-menu" hidden>
                        <a href="<?= e(admin_url('outlets/services?outlet_id=' . $o['id'])) ?>"><i class="fa-solid fa-bell-concierge"></i> Services</a>
                        <a href="<?= e(admin_url('outlets/faq?outlet_id=' . $o['id'])) ?>"><i class="fa-solid fa-circle-question"></i> FAQs</a>
                        <a href="<?= e(admin_url('outlets/hours?outlet_id=' . $o['id'])) ?>"><i class="fa-solid fa-clock"></i> Hours</a>
                        <a href="<?= e(admin_url('outlets/team?outlet_id=' . $o['id'])) ?>"><i class="fa-solid fa-user-group"></i> Team</a>
                    </div>
                </div>

                <form method="post" action="<?= e(admin_url('outlets/delete')) ?>" onsubmit="return confirm('Delete this outlet?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= (int) $o['id'] ?>">
                    <button type="submit" class="adm-link-danger"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p class="adm-empty">No outlets yet. <a href="<?= e(admin_url('outlets/new')) ?>">Add the first one</a>.</p>
<?php endif; ?>
