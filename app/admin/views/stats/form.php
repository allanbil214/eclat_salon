<?php /** Vars: $st */
$x = $st ?? ['id'=>0,'label'=>'','value'=>0,'prefix'=>'','suffix'=>'','is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $x['id'] ? 'Edit stat' : 'New stat' ?></h1><a class="adm-btn" href="<?= e(admin_url('stats')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('stats/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">
    <label class="adm-field"><span>Label</span><input type="text" name="label" value="<?= e($x['label']) ?>" required placeholder="Happy clients"></label>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Prefix</span><input type="text" name="prefix" value="<?= e($x['prefix']) ?>" placeholder="e.g. Rp"></label>
        <label class="adm-field adm-field--sm"><span>Value</span><input type="number" name="value" value="<?= (int) $x['value'] ?>"></label>
        <label class="adm-field adm-field--sm"><span>Suffix</span><input type="text" name="suffix" value="<?= e($x['suffix']) ?>" placeholder="e.g. +"></label>
    </div>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $x['is_active'] ? 'checked' : '' ?>> Visible on the site</label>
    </div>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save stat</button><a class="adm-btn" href="<?= e(admin_url('stats')) ?>">Cancel</a></div>
</form>
