<?php /** Vars: $page */
$pg = $page ?? ['id'=>0,'slug'=>'','title'=>'','body'=>'','is_active'=>1];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $pg['id'] ? 'Edit page' : 'New page' ?></h1><a class="adm-btn" href="<?= e(admin_url('pages')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('pages/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $pg['id'] ?>">
    <label class="adm-field"><span>Title</span><input type="text" name="title" value="<?= e($pg['title']) ?>" required data-slug-src></label>
    <label class="adm-field"><span>URL slug <small>· e.g. privacy → /privacy</small></span><input type="text" name="slug" value="<?= e($pg['slug']) ?>" placeholder="auto from title" data-slug-out></label>
    <div class="adm-field">
        <span>Body</span>
        <div class="adm-quill" data-quill data-target="page-body"><?= $pg['body'] ?></div>
        <input type="hidden" name="body" id="page-body" value="<?= e($pg['body']) ?>">
    </div>
    <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $pg['is_active'] ? 'checked' : '' ?>> Active (visible on the site)</label>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save page</button><a class="adm-btn" href="<?= e(admin_url('pages')) ?>">Cancel</a></div>
</form>
