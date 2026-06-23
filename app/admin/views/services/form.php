<?php /** Vars: $svc, $cats */
$s = $svc ?? ['id'=>0,'category_id'=>0,'name'=>'','description'=>'','price_from'=>'','price_to'=>'','duration_min'=>'','is_featured'=>0,'is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $s['id'] ? 'Edit service' : 'New service' ?></h1><a class="adm-btn" href="<?= e(admin_url('services')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('services/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">
    <div class="adm-field-row">
        <label class="adm-field"><span>Category</span>
            <select name="category_id" class="adm-select" required>
                <?php foreach ($cats as $c): ?><option value="<?= (int) $c['id'] ?>" <?= (int) $s['category_id'] === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
            </select>
        </label>
        <label class="adm-field"><span>Name</span><input type="text" name="name" value="<?= e($s['name']) ?>" required></label>
    </div>
    <label class="adm-field"><span>Description</span><textarea name="description" rows="3"><?= e($s['description']) ?></textarea></label>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Price from (Rp)</span><input type="number" name="price_from" value="<?= ($s['price_from'] !== null && $s['price_from'] !== '') ? (int) $s['price_from'] : '' ?>"></label>
        <label class="adm-field adm-field--sm"><span>Price to (Rp) <small>· optional</small></span><input type="number" name="price_to" value="<?= ($s['price_to'] !== null && $s['price_to'] !== '') ? (int) $s['price_to'] : '' ?>"></label>
        <label class="adm-field adm-field--sm"><span>Duration (min)</span><input type="number" name="duration_min" value="<?= ($s['duration_min'] !== null && $s['duration_min'] !== '') ? (int) $s['duration_min'] : '' ?>"></label>
    </div>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $s['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_featured" value="1" <?= $s['is_featured'] ? 'checked' : '' ?>> Featured</label>
        <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $s['is_active'] ? 'checked' : '' ?>> Active</label>
    </div>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save service</button><a class="adm-btn" href="<?= e(admin_url('services')) ?>">Cancel</a></div>
</form>
