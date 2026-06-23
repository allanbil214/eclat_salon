<?php /** Vars: $product, $gallery */
$p = $product ?? ['id'=>0,'name'=>'','slug'=>'','brand'=>'','description'=>'','price'=>'','image_url'=>'','in_stock'=>1,'sort_order'=>0];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $p['id'] ? 'Edit product' : 'New product' ?></h1><a class="adm-btn" href="<?= e(admin_url('products')) ?>">← Back</a></div>

<form method="post" action="<?= e(admin_url('products/save')) ?>" class="adm-form adm-form--wide" data-product-form>
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">

    <label class="adm-field"><span>Name</span><input type="text" name="name" value="<?= e($p['name']) ?>" required data-slug-src></label>
    <label class="adm-field"><span>Slug <small>· URL, leave blank to auto-generate</small></span><input type="text" name="slug" value="<?= e($p['slug']) ?>" placeholder="auto from name" data-slug-out></label>
    <label class="adm-field"><span>Brand</span><input type="text" name="brand" value="<?= e($p['brand']) ?>"></label>

    <div class="adm-field">
        <span>Description</span>
        <div class="adm-quill" data-quill data-target="prod-desc"><?= $p['description'] ?></div>
        <input type="hidden" name="description" id="prod-desc" value="<?= e($p['description']) ?>">
    </div>

    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Price (Rp)</span><input type="number" step="1" name="price" value="<?= ($p['price'] !== null && $p['price'] !== '') ? (int) $p['price'] : '' ?>"></label>
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $p['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="in_stock" value="1" <?= $p['in_stock'] ? 'checked' : '' ?>> In stock</label>
    </div>

    <div class="adm-field">
        <span>Main image</span>
        <div class="adm-imgfield" data-imgfield>
            <div class="adm-imgfield-preview"><?php if ($p['image_url']): ?><img src="<?= e(image($p['image_url'])) ?>" alt=""><?php endif; ?></div>
            <input type="hidden" name="image_url" value="<?= e($p['image_url']) ?>" data-imgfield-input>
            <div class="adm-imgfield-actions">
                <button type="button" class="adm-btn" data-img-pick>Choose image</button>
                <button type="button" class="adm-btn" data-img-clear>Remove</button>
            </div>
        </div>
    </div>

    <div class="adm-field">
        <span>Gallery images <small>· extra photos on the product page</small></span>
        <div class="adm-gallery" data-gallery>
            <div class="adm-gallery-list" data-gallery-list>
                <?php foreach ($gallery as $g): ?>
                    <div class="adm-gallery-item" data-gallery-item>
                        <img src="<?= e(image($g['image_url'])) ?>" alt="">
                        <input type="hidden" name="gallery[]" value="<?= e($g['image_url']) ?>">
                        <div class="adm-gallery-ctrls">
                            <button type="button" data-g-up aria-label="Move up">↑</button>
                            <button type="button" data-g-down aria-label="Move down">↓</button>
                            <button type="button" data-g-remove aria-label="Remove">✕</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="adm-btn" data-gallery-add>+ Add gallery image</button>
        </div>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save product</button>
        <a class="adm-btn" href="<?= e(admin_url('products')) ?>">Cancel</a>
    </div>
</form>
