<?php /** Vars: $outlet, $team */

// Split into: assigned here, assigned elsewhere, unassigned
$here      = [];
$elsewhere = [];
$free      = [];
foreach ($team as $m) {
    $mo = $m['outlet_id'] !== null ? (int) $m['outlet_id'] : null;
    if ($mo === (int) $outlet['id'])  $here[]      = $m;
    elseif ($mo !== null)             $elsewhere[] = $m;
    else                              $free[]       = $m;
}
?>
<div class="adm-head">
    <div>
        <h1 class="adm-h1">Team — <?= e($outlet['name']) ?></h1>
        <p class="adm-muted" style="margin:4px 0 0">Check the members who work at this outlet. Members assigned to other outlets are shown but can be reassigned.</p>
    </div>
    <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>"><i class="fa-solid fa-arrow-left"></i> Outlets</a>
</div>

<?php if (!$team): ?>
<p class="adm-empty">No team members yet. <a href="<?= e(admin_url('team/new')) ?>">Add one first</a>.</p>
<?php else: ?>
<form method="post" action="<?= e(admin_url('outlets/team/save')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">

    <table class="adm-table">
        <thead>
            <tr>
                <th class="w-min"><label title="Toggle all"><input type="checkbox" id="js-check-all"></label></th>
                <th class="w-min"></th>
                <th>Name</th>
                <th class="w-min">Role</th>
                <th class="w-min">Currently at</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Render: assigned here first, then unassigned, then elsewhere
        $sections = [
            ['rows' => $here,      'label' => null],
            ['rows' => $free,      'label' => count($here) ? 'Unassigned' : null],
            ['rows' => $elsewhere, 'label' => 'At another outlet'],
        ];
        foreach ($sections as $section):
            if (!$section['rows']) continue;
            if ($section['label']): ?>
            <tr><td colspan="5" style="background:var(--a-bg3);font-size:0.72rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--a-text3);padding:8px 16px"><?= e($section['label']) ?></td></tr>
            <?php endif;
            foreach ($section['rows'] as $m):
                $checked  = (int) $m['outlet_id'] === (int) $outlet['id'];
                $other_outlet = (!$checked && $m['outlet_name']) ? $m['outlet_name'] : null;
        ?>
        <tr<?= $other_outlet ? ' style="opacity:.7"' : '' ?>>
            <td><input type="checkbox" name="member_ids[]" value="<?= (int) $m['id'] ?>"<?= $checked ? ' checked' : '' ?> class="js-member-cb"></td>
            <td>
                <div class="adm-thumb">
                    <?php if ($m['photo_url']): ?><img src="<?= e(image($m['photo_url'])) ?>" alt=""><?php endif; ?>
                </div>
            </td>
            <td>
                <strong><?= e($m['name']) ?></strong>
                <?php if ($m['is_owner']): ?><span class="adm-badge on" style="margin-left:6px">Owner</span><?php endif; ?>
            </td>
            <td class="adm-muted"><?= e($m['role']) ?></td>
            <td class="adm-muted">
                <?php if ($checked): ?>
                    <span style="color:var(--a-ok)"><i class="fa-solid fa-circle-check"></i> This outlet</span>
                <?php elseif ($other_outlet): ?>
                    <?= e($other_outlet) ?>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; endforeach; ?>
        </tbody>
    </table>

    <div class="adm-form-actions" style="margin-top:18px">
        <button class="adm-btn adm-btn--primary" type="submit">Save assignments</button>
        <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">Cancel</a>
    </div>
</form>

<?php endif; ?>
