<?php /** Vars: $b */
$x = $b ?? ['id'=>0,'name'=>'','logo_url'=>'','website_url'=>'','sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $x['id'] ? 'Edit brand' : 'New brand' ?></h1><a class="adm-btn" href="<?= e(admin_url('brands')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('brands/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $x['id'] ?>">
    <label class="adm-field"><span>Name</span><input type="text" name="name" value="<?= e($x['name']) ?>" required></label>
    <div class="adm-field">
        <span>Logo <small>· optional — shown instead of the name</small></span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview adm-imgfield-preview--contain"><?php if (!empty($x['logo_url'])): ?><img src="<?= e(image($x['logo_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="logo_url" value="<?= e($x['logo_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions"><button type="button" class="adm-btn" data-img-pick>Choose logo</button><button type="button" class="adm-btn" data-img-clear>Remove</button></div>
        </div>
    </div>
    <label class="adm-field"><span>Website <small>· optional</small></span><input type="url" name="website_url" value="<?= e($x['website_url']) ?>" placeholder="https://…"></label>
    <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $x['sort_order'] ?>"></label>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save brand</button><a class="adm-btn" href="<?= e(admin_url('brands')) ?>">Cancel</a></div>
</form>
