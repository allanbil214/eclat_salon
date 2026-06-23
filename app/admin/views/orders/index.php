<?php /** Vars: $orders, $counts, $filter */
$tabs = ['all' => 'All'];
foreach (order_statuses() as $s) $tabs[$s] = ucfirst($s);
?>
<div class="adm-head"><h1 class="adm-h1">Orders</h1></div>
<div class="adm-tabs">
    <?php foreach ($tabs as $key => $label):
        $href = $key === 'all' ? admin_url('orders') : admin_url('orders?status=' . $key);
        $on = ($filter ?? null) === ($key === 'all' ? null : $key);
    ?>
        <a class="adm-tab<?= $on ? ' on' : '' ?>" href="<?= e($href) ?>"><?= e($label) ?> <span><?= (int) ($counts[$key] ?? 0) ?></span></a>
    <?php endforeach; ?>
</div>
<?php if ($orders): ?>
<table class="adm-table">
    <thead><tr><th class="w-min">Ref</th><th>Customer</th><th class="w-min">Items</th><th>Total</th><th class="w-min">Status</th><th class="w-min">Date</th><th class="w-min"></th></tr></thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
        <tr>
            <td><strong><?= e($o['ref']) ?></strong></td>
            <td><?= e($o['customer_name']) ?: '—' ?><div class="adm-muted"><?= e($o['customer_phone']) ?></div></td>
            <td class="adm-muted"><?= (int) $o['item_count'] ?></td>
            <td><?= e(money((float) $o['total'])) ?></td>
            <td><span class="adm-badge st-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></td>
            <td class="adm-muted"><?= e(date('j M Y', strtotime((string) $o['created_at']))) ?></td>
            <td class="adm-row-actions"><a href="<?= e(admin_url('orders/view?id=' . $o['id'])) ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <p class="adm-empty">No orders<?= $filter ? ' with this status' : '' ?> yet.</p>
<?php endif; ?>
