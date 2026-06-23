<?php /** Vars: $t */
$x = $t ?? ['id'=>0,'author'=>'','rating'=>5,'quote'=>'','service'=>'','source'=>'Google','is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $x['id'] ? 'Edit testimonial' : 'New testimonial' ?></h1><a class="adm-btn" href="<?= e(admin_url('testimonials')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('testimonials/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">
    <div class="adm-field-row">
        <label class="adm-field"><span>Author</span><input type="text" name="author" value="<?= e($x['author']) ?>" required></label>
        <label class="adm-field adm-field--sm"><span>Rating</span>
            <select name="rating" class="adm-select">
                <?php for ($r = 5; $r >= 1; $r--): ?><option value="<?= $r ?>" <?= (int) $x['rating'] === $r ? 'selected' : '' ?>><?= $r ?> ★</option><?php endfor; ?>
            </select>
        </label>
    </div>
    <label class="adm-field"><span>Quote</span><textarea name="quote" rows="4" required><?= e($x['quote']) ?></textarea></label>
    <div class="adm-field-row">
        <label class="adm-field"><span>Service <small>· optional</small></span><input type="text" name="service" value="<?= e($x['service']) ?>" placeholder="e.g. Balayage"></label>
        <label class="adm-field"><span>Source</span><input type="text" name="source" value="<?= e($x['source']) ?>" placeholder="Google"></label>
    </div>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $x['is_active'] ? 'checked' : '' ?>> Visible on the site</label>
    </div>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save testimonial</button><a class="adm-btn" href="<?= e(admin_url('testimonials')) ?>">Cancel</a></div>
</form>
