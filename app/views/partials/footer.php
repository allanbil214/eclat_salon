<?php
/** Site footer. */
$hours   = get_opening_hours();
$ig = get_setting('instagram'); $fb = get_setting('facebook');
$tt = get_setting('tiktok');    $yt = get_setting('youtube');
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-top">
            <div class="footer-brand">
                <div class="brand"><?= e(get_setting('site_name')) ?><span class="dot">.</span></div>
                <p><?= e(get_setting('tagline')) ?> — a Jakarta atelier, by appointment since <?= e(get_setting('founded_year')) ?>.</p>
                <div class="socials">
                    <a href="<?= e($ig) ?>" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                    <a href="<?= e($fb) ?>" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 22v-8h2.7l.4-3H13V9c0-.9.3-1.5 1.6-1.5H16V4.9c-.3 0-1.2-.1-2.3-.1-2.3 0-3.7 1.4-3.7 3.9V11H7v3h3v8z"/></svg></a>
                    <a href="<?= e($tt) ?>" aria-label="TikTok"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 3c.3 2 1.6 3.6 3.6 3.9v2.6c-1.3.1-2.6-.3-3.6-1v5.9a5.4 5.4 0 1 1-5.4-5.4c.3 0 .6 0 .9.1v2.7a2.7 2.7 0 1 0 1.9 2.6V3z"/></svg></a>
                    <a href="<?= e($yt) ?>" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12s0-3-.4-4.4a2.3 2.3 0 0 0-1.6-1.6C18.5 5.6 12 5.6 12 5.6s-6.5 0-8 .4A2.3 2.3 0 0 0 2.4 7.6C2 9 2 12 2 12s0 3 .4 4.4a2.3 2.3 0 0 0 1.6 1.6c1.5.4 8 .4 8 .4s6.5 0 8-.4a2.3 2.3 0 0 0 1.6-1.6C22 15 22 12 22 12zm-12 2.8V9.2l4.8 2.8z"/></svg></a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Explore</h4>
                <ul>
                    <li><a href="<?= e(url('about')) ?>">About</a></li>
                    <li><a href="<?= e(url('services')) ?>">Services &amp; Pricing</a></li>
                    <li><a href="<?= e(url('gallery')) ?>">Lookbook</a></li>
                    <li><a href="<?= e(url('blog')) ?>">Article</a></li>
                    <li><a href="<?= e(url('shop')) ?>">Shop</a></li>
                    <li><a href="<?= e(url('faq')) ?>">FAQ</a></li>
                    <li><a href="<?= e(url('book')) ?>">Book an Appointment</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Visit</h4>
                <ul>
                    <li><?= e(get_setting('address_line1')) ?></li>
                    <li><?= e(get_setting('address_line2')) ?></li>
                    <li><a href="tel:<?= e(preg_replace('/[^0-9+]/', '', get_setting('phone'))) ?>"><?= e(get_setting('phone')) ?></a></li>
                    <li><a href="mailto:<?= e(get_setting('email')) ?>"><?= e(get_setting('email')) ?></a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Hours</h4>
                <ul>
                    <?php foreach ($hours as $h): ?>
                        <li class="hours-row<?= $h['is_closed'] ? ' closed' : '' ?>">
                            <span class="d"><?= e($h['day_name']) ?></span>
                            <span class="t"><?= $h['is_closed'] ? 'Closed' : e(fmt_time($h['open_time']) . ' – ' . fmt_time($h['close_time'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© <?= date('Y') ?> <?= e(get_setting('site_name_full')) ?>. All rights reserved.</span>
            <span>Crafted in Jakarta · A demo template</span>
        </div>
    </div>
</footer>
