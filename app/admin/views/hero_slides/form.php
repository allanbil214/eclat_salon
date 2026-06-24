<?php /** Vars: $item */
$s = $item ?? ['id' => 0, 'image_url' => '', 'sort_order' => 0, 'active' => 1];
?>
<div class="adm-head">
    <h1 class="adm-h1"><?= $s['id'] ? 'Edit slide' : 'New slide' ?></h1>
    <a class="adm-btn" href="<?= e(admin_url('hero-slides')) ?>">← Back</a>
</div>
<form method="post" action="<?= e(admin_url('hero-slides/save')) ?>" class="adm-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">

    <div class="adm-field">
        <span>Image</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview">
                <?php if ($s['image_url']): ?><img src="<?= e(image($s['image_url'])) ?>" alt=""><?php endif; ?>
            </div>
            <input type="hidden" name="image_url" value="<?= e($s['image_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions">
                <button type="button" class="adm-btn" data-img-pick>Choose image</button>
                <button type="button" class="adm-btn" data-img-clear>Remove</button>
            </div>
        </div>
    </div>

    <div class="adm-field-row">
        <label class="adm-field adm-field--sm">
            <span>Sort order</span>
            <input type="number" name="sort_order" value="<?= (int) $s['sort_order'] ?>">
        </label>
        <label class="adm-check">
            <input type="checkbox" name="active" value="1" <?= $s['active'] ? 'checked' : '' ?>> Active
        </label>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save slide</button>
        <a class="adm-btn" href="<?= e(admin_url('hero-slides')) ?>">Cancel</a>
    </div>
</form>
