<?php /** Book page. Vars: $services $hours $errors $success $old */
$errors  = $errors  ?? [];
$success = $success ?? false;
$old     = $old     ?? ['name' => '', 'email' => '', 'phone' => '', 'service_id' => '', 'preferred_date' => '', 'message' => ''];
?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="https://picsum.photos/seed/eclat-book-hero/1920/1000" alt="" aria-hidden="true"></div>
    <div class="container">
        <span class="eyebrow">Appointments</span>
        <h1>Request your appointment</h1>
        <p class="lede"><?= e(get_setting('booking_note')) ?></p>
        <div class="breadcrumb"><a href="<?= e(url('')) ?>">Home</a><span class="sep">/</span>Book</div>
    </div>
</section>

<section class="section">
    <div class="container book-grid">
        <div class="reveal">
            <?php if ($success): ?>
                <div class="alert ok">
                    <strong>Thank you — your request is in.</strong><br>
                    We will confirm by email within one business day. For anything urgent, call the studio on <?= e(get_setting('phone')) ?>.
                </div>
            <?php elseif ($errors): ?>
                <div class="alert err">Please check the highlighted fields and try again.</div>
            <?php endif; ?>

            <form method="post" action="<?= e(url('book')) ?>" novalidate>
                <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                <div class="form-grid">
                    <div class="field">
                        <label for="name">Your name <span class="req">*</span></label>
                        <input id="name" name="name" type="text" value="<?= e($old['name']) ?>" placeholder="Jane Doe" required>
                        <?php if (isset($errors['name'])): ?><span class="error-text"><?= e($errors['name']) ?></span><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="email">Email <span class="req">*</span></label>
                        <input id="email" name="email" type="email" value="<?= e($old['email']) ?>" placeholder="jane@email.com" required>
                        <?php if (isset($errors['email'])): ?><span class="error-text"><?= e($errors['email']) ?></span><?php endif; ?>
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" value="<?= e($old['phone']) ?>" placeholder="Optional">
                    </div>
                    <div class="field">
                        <label for="service_id">Service</label>
                        <select id="service_id" name="service_id">
                            <option value="">No preference yet</option>
                            <?php foreach ($services as $svc): ?>
                                <option value="<?= (int) $svc['id'] ?>" <?= (string) $old['service_id'] === (string) $svc['id'] ? 'selected' : '' ?>>
                                    <?= e($svc['category_name'] . ' — ' . $svc['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label for="preferred_date">Preferred date</label>
                        <input id="preferred_date" name="preferred_date" type="date" value="<?= e($old['preferred_date']) ?>">
                    </div>
                    <div class="field full">
                        <label for="message">What are you after?</label>
                        <textarea id="message" name="message" placeholder="Tell us about your hair and the look you have in mind."><?= e($old['message']) ?></textarea>
                    </div>
                    <div class="field full">
                        <button class="btn btn-primary" type="submit">Send request <span aria-hidden="true">→</span></button>
                        <p class="form-note">We will never share your details. This sends an enquiry — your stylist confirms the final time.</p>
                    </div>
                </div>
            </form>
        </div>

        <aside class="book-aside reveal" style="--d:.1s">
            <h3>Visit the studio</h3>
            <div class="aside-block">
                <div class="lbl">Where</div>
                <div class="val"><?= e(get_setting('address_line1')) ?><br><?= e(get_setting('address_line2')) ?></div>
            </div>
            <div class="aside-block">
                <div class="lbl">Get in touch</div>
                <a class="val" href="tel:<?= e(preg_replace('/[^0-9+]/', '', get_setting('phone'))) ?>"><?= e(get_setting('phone')) ?></a><br>
                <a class="val" href="mailto:<?= e(get_setting('email')) ?>"><?= e(get_setting('email')) ?></a>
            </div>
            <div class="aside-block">
                <div class="lbl">Opening hours</div>
                <?php foreach ($hours as $h): ?>
                    <div class="hours-row<?= $h['is_closed'] ? ' closed' : '' ?>">
                        <span class="d"><?= e($h['day_name']) ?></span>
                        <span class="t"><?= $h['is_closed'] ? 'Closed' : e(fmt_time($h['open_time']) . ' – ' . fmt_time($h['close_time'])) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</section>
