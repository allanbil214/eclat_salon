<?php /** Vars: $order, $items */ ?>
<div class="adm-head">
    <div>
        <h1 class="adm-h1">Order <?= e($order['ref']) ?></h1>
        <p class="adm-muted"><?= e(date('l, j F Y · H:i', strtotime((string) $order['created_at']))) ?></p>
    </div>
    <a class="adm-btn" href="<?= e(admin_url('orders')) ?>">← All orders</a>
</div>

<div class="adm-grid-2">
    <div class="adm-panel">
        <div class="adm-panel-h">Items</div>
        <table class="adm-itable">
            <tbody>
            <?php foreach ($items as $it): ?>
                <tr>
                    <td><strong><?= e(trim($it['brand'] . ' ' . $it['product_name'])) ?></strong><div class="adm-muted"><?= e(money((float) $it['unit_price'])) ?> &times; <?= (int) $it['qty'] ?></div></td>
                    <td class="adm-right"><?= e(money((float) $it['line_total'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot><tr><td>Total</td><td class="adm-right"><strong><?= e(money((float) $order['total'])) ?></strong></td></tr></tfoot>
        </table>
    </div>

    <div class="adm-panel">
        <div class="adm-panel-h">Customer</div>
        <dl class="adm-dl">
            <dt>Name</dt><dd><?= e($order['customer_name']) ?: '—' ?></dd>
            <dt>Phone</dt><dd><?= e($order['customer_phone']) ?: '—' ?></dd>
            <dt>Email</dt><dd><?= e($order['customer_email']) ?: '—' ?></dd>
            <dt>Fulfillment</dt><dd><?= $order['fulfillment'] === 'delivery' ? 'Delivery' : 'Pickup' ?></dd>
            <?php if ($order['fulfillment'] === 'delivery' || $order['address']): ?><dt>Address</dt><dd><?= e($order['address']) ?: '—' ?></dd><?php endif; ?>
            <?php if ($order['note']): ?><dt>Note</dt><dd><?= e($order['note']) ?></dd><?php endif; ?>
        </dl>
        <?php $wa = whatsapp_customer_url($order); if ($wa): ?>
            <a class="adm-btn adm-btn--wa" href="<?= e($wa) ?>" target="_blank" rel="noopener">Reply on WhatsApp ↗</a>
        <?php endif; ?>
    </div>
</div>

<div class="adm-panel adm-mt2">
    <div class="adm-statusbar">
        <form method="post" action="<?= e(admin_url('orders/status')) ?>" class="adm-status-form">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
            <span class="adm-status-label">Status</span>
            <select name="status" class="adm-select">
                <?php foreach (order_statuses() as $s): ?>
                    <option value="<?= e($s) ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="adm-btn adm-btn--primary" type="submit">Update</button>
        </form>
        <form method="post" action="<?= e(admin_url('orders/delete')) ?>" onsubmit="return confirm('Delete this order permanently?');">
            <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
            <button type="submit" class="adm-link-danger">Delete order</button>
        </form>
    </div>
</div>
