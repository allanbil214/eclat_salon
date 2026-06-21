<?php /** Cart page. Vars: $errors $old */
$errors = $errors ?? [];
$old = $old ?? ['name'=>'','phone'=>'','email'=>'','address'=>'','fulfillment'=>'pickup','note'=>''];
?>

<section class="section cart-page" data-cart-page>
    <div class="container">
        <div class="breadcrumb breadcrumb--dark">
            <a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>
            <a href="<?= e(url('shop')) ?>">Shop</a><span class="sep">/</span>Cart
        </div>
        <h1 class="cart-title">Your cart</h1>

        <?php if ($errors): ?>
            <div class="alert err"><?= e($errors['cart'] ?? 'Please check the highlighted fields and try again.') ?></div>
        <?php endif; ?>

        <div class="cart-layout">
            <!-- Items (rendered from the browser cart) -->
            <div class="cart-main">
                <div class="cart-list" data-cart-page-items></div>
                <div class="cart-empty-state" data-cart-empty-state hidden>
                    <p>Your cart is empty.</p>
                    <a class="btn btn-primary" href="<?= e(url('shop')) ?>">Browse the shop <span aria-hidden="true">→</span></a>
                </div>
            </div>

            <!-- Summary + checkout -->
            <aside class="cart-summary" data-cart-checkout>
                <h3>Order summary</h3>
                <div class="cart-sum-row"><span>Items</span><span data-cart-count-text>0</span></div>
                <div class="cart-sum-row total"><span>Total</span><span data-cart-total><?= e(money(0)) ?></span></div>

                <form method="post" action="<?= e(url('cart')) ?>" class="cart-form" novalidate>
                    <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                    <input type="hidden" name="cart_json" data-cart-json value="">

                    <div class="field">
                        <label for="name">Name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" value="<?= e($old['name']) ?>" placeholder="Putri Andini" required>
                        <?php if (isset($errors['name'])): ?><span class="error-text"><?= e($errors['name']) ?></span><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="phone">Phone / WhatsApp <span class="req">*</span></label>
                        <input id="phone" name="phone" type="tel" value="<?= e($old['phone']) ?>" placeholder="0812 3456 7890" required>
                        <?php if (isset($errors['phone'])): ?><span class="error-text"><?= e($errors['phone']) ?></span><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="<?= e($old['email']) ?>" placeholder="Optional">
                        <?php if (isset($errors['email'])): ?><span class="error-text"><?= e($errors['email']) ?></span><?php endif; ?>
                    </div>

                    <div class="field">
                        <label>How would you like it? <span class="req">*</span></label>
                        <div class="seg" data-fulfillment>
                            <label class="seg-opt">
                                <input type="radio" name="fulfillment" value="pickup" <?= $old['fulfillment'] !== 'delivery' ? 'checked' : '' ?>>
                                <span>Pick up in-salon</span>
                            </label>
                            <label class="seg-opt">
                                <input type="radio" name="fulfillment" value="delivery" <?= $old['fulfillment'] === 'delivery' ? 'checked' : '' ?>>
                                <span>Delivery</span>
                            </label>
                        </div>
                    </div>
                    <div class="field">
                        <label for="address">Address <span class="addr-req" data-addr-req<?= $old['fulfillment'] === 'delivery' ? '' : ' hidden' ?>>*</span></label>
                        <textarea id="address" name="address" rows="2" placeholder="Where should we deliver? (leave blank for in-salon pickup)"><?= e($old['address']) ?></textarea>
                        <?php if (isset($errors['address'])): ?><span class="error-text"><?= e($errors['address']) ?></span><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="note">Note</label>
                        <textarea id="note" name="note" rows="2" placeholder="Anything we should know?"><?= e($old['note']) ?></textarea>
                    </div>

                    <button class="btn btn-primary cart-submit" type="submit" data-cart-submit>Place order on WhatsApp <span aria-hidden="true">→</span></button>
                    <p class="form-note">We'll save your order and open WhatsApp so you can confirm with the studio in one tap.</p>
                </form>
            </aside>
        </div>
    </div>
</section>
