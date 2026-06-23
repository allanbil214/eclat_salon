<?php /** Vars: $rows */ ?>
<div class="adm-head"><h1 class="adm-h1">Testimonials</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('testimonials/new')) ?>">+ New testimonial</a></div>
<?php if ($rows): ?>
<table class="adm-table">
    <thead><tr><th>Author</th><th>Quote</th><th class="w-min">Rating</th><th class="w-min">Source</th><th class="w-min">Status</th><th class="w-min">Order</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $t): ?>
        <tr>
            <td><strong><?= e($t['author']) ?></strong><?php if ($t['service']): ?><div class="adm-muted"><?= e($t['service']) ?></div><?php endif; ?></td>
            <td><div class="adm-muted adm-clip"><?= e($t['quote']) ?></div></td>
            <td class="adm-muted"><?= str_repeat('★', (int) $t['rating']) . str_repeat('☆', 5 - (int) $t['rating']) ?></td>
            <td class="adm-muted"><?= e($t['source']) ?></td>
            <td><?= $t['is_active'] ? '<span class="adm-badge on">Active</span>' : '<span class="adm-badge off">Hidden</span>' ?></td>
            <td class="adm-muted"><?= (int) $t['sort_order'] ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('testimonials/edit?id=' . $t['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('testimonials/delete')) ?>" onsubmit="return confirm('Delete this testimonial?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $t['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No testimonials yet. <a href="<?= e(admin_url('testimonials/new')) ?>">Add the first one</a>.</p><?php endif; ?>
