<?php /** Slide-in cart drawer. Rendered on every page; filled by cart.js. */ ?>
<div class="cart-drawer" data-cart-drawer aria-hidden="true">
    <div class="cart-scrim" data-cart-close></div>
    <aside class="cart-panel" role="dialog" aria-label="Your cart" aria-modal="true">
        <header class="cart-panel-head">
            <span>Your cart <span class="cart-panel-count" data-cart-count-text>0</span></span>
            <button class="cart-close" type="button" data-cart-close aria-label="Close cart">&times;</button>
        </header>

        <div class="cart-panel-items" data-cart-drawer-items></div>

        <div class="cart-panel-empty" data-cart-empty-state>
            <p>Your cart is empty.</p>
            <a class="btn-text" href="<?= e(url('shop')) ?>" data-cart-close>Browse the shop →</a>
        </div>

        <footer class="cart-panel-foot" data-cart-foot>
            <div class="cart-sum-row total"><span>Total</span><span data-cart-total><?= e(money(0)) ?></span></div>
            <a class="btn btn-primary" href="<?= e(url('cart')) ?>">Checkout <span aria-hidden="true">→</span></a>
            <button class="btn-text" type="button" data-cart-close>Continue shopping</button>
        </footer>
    </aside>
</div>
