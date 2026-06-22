<?php /** Vars: $error, $username */ ?>
<div class="adm-login">
    <div class="adm-login-card">
        <div class="adm-brand center"><a href="<?= e(url('')) ?>">ÉCLAT<span>.</span></a><small>Dashboard</small></div>
        <h1>Sign in</h1>
        <?php if (!empty($error)): ?><div class="adm-flash adm-flash--err"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="<?= e(admin_url('login')) ?>" class="adm-form">
            <?= csrf_field() ?>
            <label class="adm-field"><span>Username</span><input type="text" name="username" value="<?= e($username ?? '') ?>" autocomplete="username" autofocus required></label>
            <label class="adm-field"><span>Password</span><input type="password" name="password" autocomplete="current-password" required></label>
            <button class="adm-btn adm-btn--primary adm-btn--block" type="submit">Sign in</button>
        </form>
    </div>
</div>
