<?php /** Vars: $hours */
/* Group rows by outlet (null outlet_id → key 0 = "All Outlets / General") */
$byOutlet = [];
foreach ($hours as $h) {
    $key = $h['outlet_id'] !== null ? (int) $h['outlet_id'] : 0;
    if (!isset($byOutlet[$key])) {
        $byOutlet[$key] = ['outlet_name' => $h['outlet_name'] ?? null, 'rows' => []];
    }
    $byOutlet[$key]['rows'][] = $h;
}
?>
<div class="adm-head"><h1 class="adm-h1">Opening hours</h1></div>
<form method="post" action="<?= e(admin_url('hours/save')) ?>" class="adm-form adm-form--wide">
    <?= csrf_field() ?>
    <?php foreach ($byOutlet as $outletId => $group): ?>
        <div class="adm-panel-h" style="margin-bottom:8px">
            <?php if ($outletId === 0 || $group['outlet_name'] === null): ?>
                General (no specific outlet)
            <?php else: ?>
                <?= e($group['outlet_name']) ?>
            <?php endif; ?>
        </div>
        <table class="adm-table" style="margin-bottom:24px">
            <thead><tr><th>Day</th><th class="w-min">Opens</th><th class="w-min">Closes</th><th class="w-min">Closed</th></tr></thead>
            <tbody>
            <?php foreach ($group['rows'] as $h): $id = (int) $h['id']; ?>
                <tr>
                    <td><strong><?= e($h['day_name']) ?></strong></td>
                    <td><input type="time" name="open[<?= $id ?>]" value="<?= e(substr((string) $h['open_time'], 0, 5)) ?>" class="adm-time"></td>
                    <td><input type="time" name="close[<?= $id ?>]" value="<?= e(substr((string) $h['close_time'], 0, 5)) ?>" class="adm-time"></td>
                    <td><label class="adm-check"><input type="checkbox" name="closed[<?= $id ?>]" value="1" <?= $h['is_closed'] ? 'checked' : '' ?>></label></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
    <p class="adm-note" style="margin-top:14px">Tick "Closed" for days the salon is shut — the times are ignored on those days.</p>
    <div class="adm-form-actions"><button class="adm-btn adm-btn--primary" type="submit">Save hours</button></div>
</form>
