<?php /** Vars: $hours */ ?>
<div class="adm-head"><h1 class="adm-h1">Opening hours</h1></div>
<form method="post" action="<?= e(admin_url('hours/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <table class="adm-table">
        <thead><tr><th>Day</th><th class="w-min">Opens</th><th class="w-min">Closes</th><th class="w-min">Closed</th></tr></thead>
        <tbody>
        <?php foreach ($hours as $h): $id = (int) $h['id']; ?>
            <tr>
                <td><strong><?= e($h['day_name']) ?></strong></td>
                <td><input type="time" name="open[<?= $id ?>]" value="<?= e(substr((string) $h['open_time'], 0, 5)) ?>" class="adm-time"></td>
                <td><input type="time" name="close[<?= $id ?>]" value="<?= e(substr((string) $h['close_time'], 0, 5)) ?>" class="adm-time"></td>
                <td><label class="adm-check"><input type="checkbox" name="closed[<?= $id ?>]" value="1" <?= $h['is_closed'] ? 'checked' : '' ?>></label></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p class="adm-note" style="margin-top:14px">Tick "Closed" for days the salon is shut — the times are ignored on those days.</p>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save hours</button></div>
</form>
