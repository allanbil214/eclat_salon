<?php /** Vars: $cat */
$c = $cat ?? ['id'=>0,'name'=>'','slug'=>'','sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $c['id'] ? 'Edit category' : 'New category' ?></h1><a class="adm-btn" href="<?= e(admin_url('gallery/categories')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('gallery/categories/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
    <label class="adm-field"><span>Name</span><input type="text" name="name" value="<?= e($c['name']) ?>" required data-slug-src></label>
    <label class="adm-field"><span>Slug <small>· used in the filter URL</small></span><input type="text" name="slug" value="<?= e($c['slug']) ?>" placeholder="auto from name" data-slug-out></label>
    <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $c['sort_order'] ?>"></label>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save category</button><a class="adm-btn" href="<?= e(admin_url('gallery/categories')) ?>">Cancel</a></div>
</form>
