<?php
$x = $o ?? ['id'=>0,'name'=>'','slug'=>'','city'=>'','address'=>'','phone'=>'','whatsapp'=>'','gmaps_url'=>'','photo_url'=>'','is_active'=>1,'sort_order'=>0];
?>
<div class="adm-head">
    <h1 class="adm-h1"><?= $x['id'] ? 'Edit outlet' : 'New outlet' ?></h1>
    <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">← Back</a>
</div>

<form method="post" action="<?= e(admin_url('outlets/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">

    <label class="adm-field"><span>Name <small>· e.g. ÉCLAT Sudirman</small></span><input type="text" name="name" value="<?= e($x['name']) ?>" required></label>
    <label class="adm-field"><span>Slug <small>· URL-safe, auto-generated if blank · e.g. sudirman</small></span><input type="text" name="slug" value="<?= e($x['slug']) ?>" pattern="[a-z0-9-]+" placeholder="auto"></label>
    <label class="adm-field"><span>City <small>· e.g. Jakarta Pusat</small></span><input type="text" name="city" value="<?= e($x['city']) ?>"></label>
    <label class="adm-field"><span>Full address</span><textarea name="address" rows="3"><?= e($x['address']) ?></textarea></label>
    <label class="adm-field"><span>Phone</span><input type="text" name="phone" value="<?= e($x['phone']) ?>" placeholder="+62 21 1234 5678"></label>
    <label class="adm-field"><span>WhatsApp number <small>· digits only, with country code · e.g. 6221123456780</small></span><input type="text" name="whatsapp" value="<?= e($x['whatsapp']) ?>" placeholder="6221..."></label>
    <label class="adm-field"><span>Google Maps URL</span><input type="url" name="gmaps_url" value="<?= e($x['gmaps_url']) ?>" placeholder="https://maps.google.com/…"></label>

    <div class="adm-field">
        <span>Photo</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview">
                <?php if (!empty($x['photo_url'])): ?><img src="<?= e(image($x['photo_url'])) ?>" alt=""><?php endif; ?>
            </div>
            <input type="hidden" name="photo_url" value="<?= e($x['photo_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions">
                <button type="button" class="adm-btn" data-img-pick>Choose photo</button>
                <button type="button" class="adm-btn" data-img-clear>Remove</button>
            </div>
        </div>
    </div>

    <div class="adm-field adm-field--check">
        <label><input type="checkbox" name="is_active" value="1"<?= $x['is_active'] ? ' checked' : '' ?>> Active (visible on site)</label>
    </div>
    <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save outlet</button>
        <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">Cancel</a>
    </div>
</form>
