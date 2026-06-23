<?php /** Vars: $posts */ ?>
<div class="adm-head"><h1 class="adm-h1">Articles</h1><a class="adm-btn adm-btn--primary" href="<?= e(admin_url('articles/new')) ?>">+ New article</a></div>
<?php if ($posts): ?>
<table class="adm-table">
    <thead><tr><th class="w-min"></th><th>Title</th><th class="w-min">Category</th><th class="w-min">Status</th><th class="w-min">Date</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($posts as $p): ?>
        <tr>
            <td><div class="adm-thumb"><?php if ($p['cover_url']): ?><img src="<?= e(image($p['cover_url'])) ?>" alt=""><?php endif; ?></div></td>
            <td><strong><?= e($p['title']) ?></strong><div class="adm-muted adm-clip"><?= e($p['excerpt']) ?></div></td>
            <td class="adm-muted"><?= e($p['category']) ?: '—' ?></td>
            <td><?= $p['is_published'] ? '<span class="adm-badge on">Published</span>' : '<span class="adm-badge off">Draft</span>' ?></td>
            <td class="adm-muted"><?= $p['published_at'] ? e(date('j M Y', strtotime((string) $p['published_at']))) : '—' ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('articles/edit?id=' . $p['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('articles/delete')) ?>" onsubmit="return confirm('Delete this article?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $p['id'] ?>"><button type="submit" class="adm-link-danger">Delete</button></form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?><p class="adm-empty">No articles yet. <a href="<?= e(admin_url('articles/new')) ?>">Write the first one</a>.</p><?php endif; ?>
