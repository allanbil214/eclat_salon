<?php /** Vars: $m */
$x = $m ?? ['id'=>0,'name'=>'','role'=>'','specialty'=>'','bio'=>'','photo_url'=>'','instagram'=>'','years_exp'=>'','is_owner'=>0,'is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $x['id'] ? 'Edit team member' : 'New team member' ?></h1><a class="adm-btn" href="<?= e(admin_url('team')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('team/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">
    <div class="adm-field-row">
        <label class="adm-field"><span>Name</span><input type="text" name="name" value="<?= e($x['name']) ?>" required></label>
        <label class="adm-field"><span>Role</span><input type="text" name="role" value="<?= e($x['role']) ?>" required placeholder="e.g. Senior Colourist"></label>
    </div>
    <label class="adm-field"><span>Specialty</span><input type="text" name="specialty" value="<?= e($x['specialty']) ?>" placeholder="e.g. Balayage & lived-in colour"></label>
    <label class="adm-field"><span>Bio</span><textarea name="bio" rows="4"><?= e($x['bio']) ?></textarea></label>
    <div class="adm-field">
        <span>Photo</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview"><?php if ($x['photo_url']): ?><img src="<?= e(image($x['photo_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="photo_url" value="<?= e($x['photo_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions"><button type="button" class="adm-btn" data-img-pick>Choose photo</button><button type="button" class="adm-btn" data-img-clear>Remove</button></div>
        </div>
    </div>
    <div class="adm-field-row">
        <label class="adm-field"><span>Instagram <small>· handle or URL</small></span><input type="text" name="instagram" value="<?= e($x['instagram']) ?>"></label>
        <label class="adm-field adm-field--sm"><span>Years experience</span><input type="number" name="years_exp" value="<?= ($x['years_exp'] !== null && $x['years_exp'] !== '') ? (int) $x['years_exp'] : '' ?>"></label>
    </div>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_owner" value="1" <?= $x['is_owner'] ? 'checked' : '' ?>> Owner</label>
        <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $x['is_active'] ? 'checked' : '' ?>> Active</label>
    </div>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save team member</button><a class="adm-btn" href="<?= e(admin_url('team')) ?>">Cancel</a></div>
</form>
