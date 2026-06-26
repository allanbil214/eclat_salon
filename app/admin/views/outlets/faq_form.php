<?php /** Vars: $outlet, $faq */
$f = $faq ?? ['id'=>0,'question'=>'','answer'=>'','sort_order'=>0,'is_active'=>1];
?>
<div class="adm-head">
    <h1 class="adm-h1"><?= $f['id'] ? 'Edit FAQ' : 'Add FAQ' ?> — <?= e($outlet['name']) ?></h1>
    <a class="adm-btn" href="<?= e(admin_url('outlets/faq?outlet_id=' . (int) $outlet['id'])) ?>">← Back</a>
</div>

<form method="post" action="<?= e(admin_url('outlets/faq/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">
    <input type="hidden" name="id" value="<?= (int) $f['id'] ?>">

    <label class="adm-field">
        <span>Question</span>
        <input type="text" name="question" value="<?= e($f['question']) ?>" required placeholder="e.g. Is there parking available at this location?">
    </label>
    <label class="adm-field">
        <span>Answer</span>
        <textarea name="answer" rows="5" required placeholder="e.g. Yes, there is free parking available in the basement…"><?= e($f['answer']) ?></textarea>
    </label>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span>
            <input type="number" name="sort_order" value="<?= (int) $f['sort_order'] ?>">
        </label>
        <div class="adm-field" style="justify-content:flex-end;padding-top:24px">
            <label><input type="checkbox" name="is_active" value="1"<?= $f['is_active'] ? ' checked' : '' ?>> Active (visible on outlet page)</label>
        </div>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save FAQ</button>
        <a class="adm-btn" href="<?= e(admin_url('outlets/faq?outlet_id=' . (int) $outlet['id'])) ?>">Cancel</a>
    </div>
</form>
