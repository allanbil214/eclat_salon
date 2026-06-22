<?php /** Vars: $faq (null for new) */
$f = $faq ?? ['id' => 0, 'question' => '', 'answer' => '', 'sort_order' => 0, 'is_active' => 1];
?>
<div class="adm-head"><h1 class="adm-h1"><?= $f['id'] ? 'Edit FAQ' : 'New FAQ' ?></h1><a class="adm-btn" href="<?= e(admin_url('faq')) ?>">← Back</a></div>
<form method="post" action="<?= e(admin_url('faq/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $f['id'] ?>">
    <label class="adm-field"><span>Question</span><input type="text" name="question" value="<?= e($f['question']) ?>" required></label>
    <label class="adm-field"><span>Answer</span><textarea name="answer" rows="5" required><?= e($f['answer']) ?></textarea></label>
    <div class="adm-field-row">
        <label class="adm-field adm-field--sm"><span>Sort order</span><input type="number" name="sort_order" value="<?= (int) $f['sort_order'] ?>"></label>
        <label class="adm-check"><input type="checkbox" name="is_active" value="1" <?= $f['is_active'] ? 'checked' : '' ?>> Visible on the site</label>
    </div>
    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">Save</button>
        <a class="adm-btn" href="<?= e(admin_url('faq')) ?>">Cancel</a>
    </div>
</form>
