<?php /** Vars: $d, $admin */
$first = !empty($admin['name']) ? explode(' ', $admin['name'])[0] : 'there';
$c = $d['counts'];
$ordTotal = max(1, $d['counts']['orders']);
$statusMeta = ['new' => 'New', 'contacted' => 'Contacted', 'completed' => 'Completed'];
?>
<p class="adm-welcome">Welcome back, <?= e($first) ?>.</p>

<div class="adm-tiles">
    <div class="adm-tile adm-tile--accent">
        <div class="adm-tile-l">Revenue · this month</div>
        <div class="adm-tile-n"><?= e(money($d['rev_month'])) ?></div>
        <div class="adm-tile-foot">All time <?= e(money($d['rev_all'])) ?></div>
    </div>
    <div class="adm-tile">
        <div class="adm-tile-l">New orders</div>
        <div class="adm-tile-n"><?= (int) $c['new_orders'] ?></div>
        <div class="adm-tile-foot"><?= (int) $c['orders'] ?> total</div>
    </div>
    <div class="adm-tile">
        <div class="adm-tile-l">Booking requests</div>
        <div class="adm-tile-n"><?= (int) $c['bookings'] ?></div>
        <div class="adm-tile-foot">all time</div>
    </div>
    <div class="adm-tile">
        <div class="adm-tile-l">Catalogue</div>
        <div class="adm-tile-n"><?= (int) $c['products'] ?></div>
        <div class="adm-tile-foot"><?= (int) $c['posts'] ?> articles · <?= (int) $c['faqs'] ?> FAQs</div>
    </div>
</div>

<div class="adm-grid-2">
    <div class="adm-panel">
        <div class="adm-panel-h">Revenue · last 14 days</div>
        <div class="adm-chart-wrap"><canvas id="adm-orders-chart"></canvas></div>
        <script type="application/json" id="adm-chart-data"><?= json_encode($d['chart']) ?></script>
    </div>
    <div class="adm-panel">
        <div class="adm-panel-h">Orders by status</div>
        <div class="adm-status">
            <?php foreach ($statusMeta as $key => $label): $n = (int) ($d['status'][$key] ?? 0); ?>
                <div class="adm-status-row">
                    <span class="adm-status-l"><?= e($label) ?></span>
                    <span class="adm-status-bar"><span class="adm-status-fill st-<?= e($key) ?>" style="width:<?= (int) round($n / $ordTotal * 100) ?>%"></span></span>
                    <span class="adm-status-n"><?= $n ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="adm-panel-h adm-mt">Manage</div>
        <div class="adm-chips">
            <a class="adm-chip on" href="<?= e(admin_url('faq')) ?>">FAQ · <?= (int) $c['faqs'] ?></a>
            <span class="adm-chip">Products · <?= (int) $c['products'] ?></span>
            <span class="adm-chip">Articles · <?= (int) $c['posts'] ?></span>
        </div>
    </div>
</div>

<div class="adm-grid-2">
    <div class="adm-panel">
        <div class="adm-panel-h">Recent orders <span class="adm-soon">Phase 2</span></div>
        <?php if ($d['recent_orders']): ?>
            <ul class="adm-recent">
                <?php foreach ($d['recent_orders'] as $o): ?>
                    <li>
                        <span class="adm-recent-main"><strong><?= e($o['ref']) ?></strong> · <?= e($o['customer_name']) ?></span>
                        <span class="adm-recent-meta"><?= e(money((float) $o['total'])) ?> · <span class="adm-badge st-<?= e($o['status']) ?>"><?= e($o['status']) ?></span></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?><p class="adm-empty-sm">No orders yet.</p><?php endif; ?>
    </div>
    <div class="adm-panel">
        <div class="adm-panel-h">Recent booking requests <span class="adm-soon">Phase 5</span></div>
        <?php if ($d['recent_bookings']): ?>
            <ul class="adm-recent">
                <?php foreach ($d['recent_bookings'] as $b): ?>
                    <li>
                        <span class="adm-recent-main"><strong><?= e($b['name']) ?></strong> · <?= e($b['phone']) ?></span>
                        <span class="adm-recent-meta"><?= $b['preferred_date'] ? e(date('j M', strtotime((string) $b['preferred_date']))) : '—' ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?><p class="adm-empty-sm">No booking requests yet.</p><?php endif; ?>
    </div>
</div>

<p class="adm-note">Phase 1 is live (login, layout, FAQ). Orders, products and articles management arrive in the next phases.</p>

<?php if (!empty($chart)): ?>
<script defer src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<?= js('dashboard') ?>
<?php endif; ?>
