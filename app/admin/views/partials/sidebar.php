<?php /** Admin sidebar. Var: $active */
$nav = ['dashboard' => ['Dashboard', admin_url('')], 'faq' => ['FAQ', admin_url('faq')]];
$soon = ['Products', 'Orders', 'Articles', 'Pages', 'Gallery', 'Settings'];
?>
<aside class="adm-side">
    <div class="adm-brand"><a href="<?= e(admin_url('')) ?>">ÉCLAT<span>.</span></a><small>Dashboard</small></div>
    <nav class="adm-nav">
        <?php foreach ($nav as $key => [$label, $href]): ?>
            <a href="<?= e($href) ?>"<?= $active === $key ? ' class="on"' : '' ?>><?= e($label) ?></a>
        <?php endforeach; ?>
        <div class="adm-nav-soon">Coming in later phases</div>
        <?php foreach ($soon as $s): ?><span class="adm-nav-dis"><?= e($s) ?></span><?php endforeach; ?>
    </nav>
</aside>
