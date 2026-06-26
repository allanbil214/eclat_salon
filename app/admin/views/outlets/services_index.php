<?php /** Vars: $outlet, $rows */ ?>
<div class="adm-head">
    <div>
        <h1 class="adm-h1">Services — <?= e($outlet['name']) ?></h1>
        <p class="adm-muted" style="margin:4px 0 0">Per-outlet service list with outlet-specific pricing.</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
        <?php if (get_all_services()): ?>
        <button type="button" class="adm-btn" id="js-import-btn">⬇ Import from global</button>
        <?php endif; ?>
        <a class="adm-btn adm-btn--primary" href="<?= e(admin_url('outlets/services/new?outlet_id=' . (int) $outlet['id'])) ?>">+ Add service</a>
        <a class="adm-btn" href="<?= e(admin_url('outlets')) ?>">← Outlets</a>
    </div>
</div>

<?php if ($rows): ?>
<table class="adm-table">
    <thead>
        <tr>
            <th>Category</th>
            <th>Name</th>
            <th class="w-min">Price from</th>
            <th class="w-min">Price to</th>
            <th class="w-min">Order</th>
            <th class="w-min">Active</th>
            <th class="w-min"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td class="adm-muted"><?= e($r['category_name']) ?: '—' ?></td>
            <td><strong><?= e($r['name']) ?></strong></td>
            <td class="adm-muted"><?= $r['price_from'] !== null ? 'Rp ' . number_format((float)$r['price_from'], 0, ',', '.') : '—' ?></td>
            <td class="adm-muted"><?= $r['price_to'] !== null   ? 'Rp ' . number_format((float)$r['price_to'],   0, ',', '.') : '—' ?></td>
            <td class="adm-muted"><?= (int) $r['sort_order'] ?></td>
            <td class="adm-muted"><?= $r['is_active'] ? '✓' : '—' ?></td>
            <td class="adm-row-actions">
                <a href="<?= e(admin_url('outlets/services/edit?outlet_id=' . (int) $outlet['id'] . '&id=' . (int) $r['id'])) ?>">Edit</a>
                <form method="post" action="<?= e(admin_url('outlets/services/delete')) ?>" onsubmit="return confirm('Remove this service?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button type="submit" class="adm-link-danger">Remove</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p class="adm-empty">No services yet for this outlet. <a href="<?= e(admin_url('outlets/services/new?outlet_id=' . (int) $outlet['id'])) ?>">Add one</a><?php if (get_all_services()): ?> or <button type="button" class="adm-empty-link" id="js-import-btn2" style="background:none;border:0;color:var(--a-accent);font:inherit;font-size:inherit;cursor:pointer;padding:0">import from global services</button><?php endif; ?>.</p>
<?php endif; ?>

<?php
// Import modal — only shown when global services exist
$global = get_all_services();
if ($global):
    // Group by category_name for display
    $grouped = [];
    foreach ($global as $g) {
        $cat = $g['category_name'];
        $grouped[$cat][] = $g;
    }
?>
<div class="adm-modal" id="js-import-modal" hidden>
    <div class="adm-modal-scrim" id="js-import-scrim"></div>
    <div class="adm-modal-box" role="dialog" aria-label="Import services" style="width:min(560px,100%)">
        <div class="adm-modal-head">
            <span>Import from global services</span>
            <button type="button" class="adm-modal-x" id="js-import-close" aria-label="Close">&times;</button>
        </div>
        <div class="adm-modal-body" style="max-height:60vh;overflow-y:auto">
            <p class="adm-muted" style="margin:0 0 16px">Check the services to import. Prices are pre-filled from the global list — you can adjust them after import.</p>
            <form method="post" action="<?= e(admin_url('outlets/services/import')) ?>" id="js-import-form">
                <?= csrf_field() ?>
                <input type="hidden" name="outlet_id" value="<?= (int) $outlet['id'] ?>">
                <?php foreach ($grouped as $cat => $items): ?>
                <div style="margin-bottom:18px">
                    <div style="font-size:0.75rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--a-text3);margin-bottom:8px"><?= e($cat) ?></div>
                    <?php foreach ($items as $g): ?>
                    <label style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid var(--a-line);cursor:pointer">
                        <input type="checkbox" name="service_ids[]" value="<?= (int) $g['id'] ?>">
                        <span style="flex:1"><?= e($g['name']) ?></span>
                        <span class="adm-muted" style="font-size:0.82rem;white-space:nowrap">
                            <?php if ($g['price_from'] !== null): ?>
                                Rp <?= number_format((float)$g['price_from'], 0, ',', '.') ?><?= $g['price_to'] !== null ? ' – ' . number_format((float)$g['price_to'], 0, ',', '.') : '' ?>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <div style="margin-top:18px;display:flex;gap:10px;justify-content:flex-end">
                    <button type="button" class="adm-btn" id="js-import-cancel">Cancel</button>
                    <button type="submit" class="adm-btn adm-btn--primary">Import selected</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
(function(){
    var modal  = document.getElementById('js-import-modal');
    var open   = [document.getElementById('js-import-btn'), document.getElementById('js-import-btn2')];
    var closes = [document.getElementById('js-import-close'), document.getElementById('js-import-cancel'), document.getElementById('js-import-scrim')];
    open.forEach(function(b){ if(b) b.addEventListener('click', function(){ modal.hidden = false; }); });
    closes.forEach(function(b){ if(b) b.addEventListener('click', function(){ modal.hidden = true; }); });
})();
</script>
<?php endif; ?>
