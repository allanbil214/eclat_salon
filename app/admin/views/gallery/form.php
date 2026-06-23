<?php /** Vars: $item, $cats, $team */
$g = $item ?? ['id'=>0,'category_id'=>0,'title'=>'','image_url'=>'','before_image_url'=>'','stylist_id'=>null,'is_featured'=>0,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $g['id'] ? 'Edit photo' : 'New photo' ?></h1><a class="adm-btn" href="<?= e(admin_url('gallery')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('gallery/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $g['id'] ?>">
    <div class="adm-field-row">
        <label class="adm-field"><span>Category</span>
            <select name="category_id" class="adm-select" required>
                <?php foreach ($cats as $c): ?><option value="<?= (int) $c['id'] ?>" <?= (int) $g['category_id'] === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?>
            </select>
        </label>
        <label class="adm-field"><span>Stylist <small>· optional</small></span>
            <select name="stylist_id" class="adm-select">
                <option value="">— none —</option>
                <?php foreach ($team as $m): ?><option value="<?= (int) $m['id'] ?>" <?= (string) $g['stylist_id'] === (string) $m['id'] ? 'selected' : '' ?>><?= e($m['name']) ?></option><?php endforeach; ?>
            </select>
        </label>
    </div>
    <label class="adm-field"><span>Title</span><input type="text" name="title" value="<?= e($g['title']) ?>"></label>

    <div class="adm-field">
        <span>Main image <small>· the "after" shot</small></span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview"><?php if ($g['image_url']): ?><img src="<?= e(image($g['image_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="image_url" value="<?= e($g['image_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions"><button type="button" class="adm-btn" data-img-pick>Choose image</button><button type="button" class="adm-btn" data-img-clear>Remove</button></div>
        </div>
    </div>

    <div class="adm-field">
        <span>Before image <small>· optional — set this to make it a before/after slider</small></span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview"><?php if (!empty($g['before_image_url'])): ?><img src="<?= e(image($g['before_image_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="before_image_url" value="<?= e($g['before_image_url'] ?? '') ?>" data-imgfield-input>
            <div class="adm-imgfield-actions"><button type="button" class="adm-btn" data-img-pick>Choose image</button><button type="button" class="adm-btn" data-img-clear>Remove</button></div>
        </div>
    </div>

    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $g['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_featured" value="1" <?= $g['is_featured'] ? 'checked' : '' ?>> Featured</label>
    </div>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save photo</button><a class="adm-btn" href="<?= e(admin_url('gallery')) ?>">Cancel</a></div>
</form>
