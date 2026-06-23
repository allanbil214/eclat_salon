<?php /** Vars: $post, $categories */
$p = $post ?? ['id'=>0,'title'=>'','slug'=>'','excerpt'=>'','body'=>'','cover_url'=>'','author'=>'','category'=>'','is_published'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $p['id'] ? 'Edit article' : 'New article' ?></h1><a class="adm-btn" href="<?= e(admin_url('articles')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('articles/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
    <label class="adm-field"><span>Title</span><input type="text" name="title" value="<?= e($p['title']) ?>" required data-slug-src></label>
    <label class="adm-field"><span>Slug <small>· URL, leave blank to auto-generate</small></span><input type="text" name="slug" value="<?= e($p['slug']) ?>" placeholder="auto from title" data-slug-out></label>
    <div class="adm-field-row">
        <label class="adm-field"><span>Category</span><input type="text" name="category" value="<?= e($p['category']) ?>" list="cat-list" placeholder="e.g. Care"></label>
        <label class="adm-field"><span>Author</span><input type="text" name="author" value="<?= e($p['author']) ?>"></label>
    </div>
    <datalist id="cat-list"><?php foreach ($categories as $c): ?><option value="<?= e($c) ?>"></option><?php endforeach; ?></datalist>
    <label class="adm-field"><span>Excerpt <small>· short summary shown on cards</small></span><textarea name="excerpt" rows="2"><?= e($p['excerpt']) ?></textarea></label>
    <div class="adm-field">
        <span>Cover image</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview"><?php if ($p['cover_url']): ?><img src="<?= e(image($p['cover_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="cover_url" value="<?= e($p['cover_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions"><button type="button" class="adm-btn" data-img-pick>Choose image</button><button type="button" class="adm-btn" data-img-clear>Remove</button></div>
        </div>
    </div>
    <div class="adm-field">
        <span>Body</span>
        <div class="adm-quill" data-quill data-target="post-body"><?= $p['body'] ?></div>
        <input type="hidden" name="body" id="post-body" value="<?= e($p['body']) ?>">
    </div>
    <label class="adm-check"><input type="checkbox" name="is_published" value="1" <?= $p['is_published'] ? 'checked' : '' ?>> Published (visible on the site)</label>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save article</button><a class="adm-btn" href="<?= e(admin_url('articles')) ?>">Cancel</a></div>
</form>
