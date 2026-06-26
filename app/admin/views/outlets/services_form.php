<?php /** Vars: $outlet, $svc, $global_services */
$s = $svc ?? ['id'=>0,'category_name'=>'','name'=>'','price_from'=>'','price_to'=>'','sort_order'=>0,'is_active'=>1];

// Build unique category list from global services for the dropdown
$cat_options = [];
if ($global_services) {
    foreach ($global_services as $g) {
        $cn = $g['category_name'];
        if ($cn !== '' && !in_array($cn, $cat_options, true)) {
            $cat_options[] = $cn;
        }
    }
}
?>
<div class="adm-head">
    <h1 class="adm-h1"><?= $s['id'] ? 'Edit service' : 'Add service' ?> — <?= e($outlet['name']) ?></h1>
    <a class="adm-btn" href="<?= e(admin_url('outlets/services?outlet_id=' . (int) $outlet['id'])) ?>">← Back</a>
</div>

<form method="post" action="<?= e(admin_url('outlets/services/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">
    <input type="hidden" name="id" value="<?= (int) $s['id'] ?>">

    <?php if (!$s['id'] && $global_services): ?>
    <div class="adm-field" style="background:var(--a-bg3);border:1px solid var(--a-line);border-radius:var(--a-radius-sm);padding:12px 16px">
        <span style="font-size:0.82rem;color:var(--a-text2)">💡 Tip: Use <strong><a href="<?= e(admin_url('outlets/services?outlet_id=' . (int) $outlet['id'])) ?>" style="color:var(--a-accent)">Import from global</a></strong> on the list page to bulk-add services and then adjust their prices here.</span>
    </div>
    <?php endif; ?>

    <div class="adm-field-row">
        <label class="adm-field">
            <span>Category</span>
            <?php if ($cat_options): ?>
            <select name="category_name" class="adm-select">
                <option value="">— select category —</option>
                <?php foreach ($cat_options as $c): ?>
                <option value="<?= e($c) ?>"<?= $s['category_name'] === $c ? ' selected' : '' ?>><?= e($c) ?></option>
                <?php endforeach; ?>
            </select>
            <?php else: ?>
            <input type="text" name="category_name" value="<?= e($s['category_name']) ?>" placeholder="e.g. Hair">
            <?php endif; ?>
        </label>
        <label class="adm-field">
            <span>Service name</span>
            <input type="text" name="name" value="<?= e($s['name']) ?>" required placeholder="e.g. Deep Conditioning Treatment">
        </label>
    </div>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Price from (Rp)</span>
            <input type="number" name="price_from" value="<?= ($s['price_from'] !== null && $s['price_from'] !== '') ? (int) $s['price_from'] : '' ?>" min="0" step="1000">
        </label>
        <label class="adm-field adm-field--sm"><span>Price to (Rp) <small>· optional</small></span>
            <input type="number" name="price_to" value="<?= ($s['price_to'] !== null && $s['price_to'] !== '') ? (int) $s['price_to'] : '' ?>" min="0" step="1000">
        </label>
        <label class="adm-field adm-field--sm"><span>Sort order</span>
            <input type="number" name="sort_order" value="<?= (int) $s['sort_order'] ?>">
        </label>
    </div>
    <div class="adm-field--check">
        <label><input type="checkbox" name="is_active" value="1"<?= $s['is_active'] ? ' checked' : '' ?>> Active (visible on outlet page)</label>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save service</button>
        <a class="adm-btn" href="<?= e(admin_url('outlets/services?outlet_id=' . (int) $outlet['id'])) ?>">Cancel</a>
    </div>
</form>
