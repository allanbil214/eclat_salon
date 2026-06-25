<?php /** Book page. Vars: $services $outlets $hours $errors $old */
$errors  = $errors  ?? [];
$old     = $old     ?? ['name' => '', 'email' => '', 'phone' => '', 'outlet_id' => '', 'service_id' => '', 'preferred_date' => '', 'message' => ''];

// Build outlets JSON for JS dynamic aside
$outlets_json = json_encode(array_map(fn($o) => [
    'id'        => (int) $o['id'],
    'name'      => $o['name'],
    'city'      => $o['city'],
    'address'   => $o['address'],
    'phone'     => $o['phone'],
    'whatsapp'  => preg_replace('/\D/', '', $o['whatsapp']),
    'gmaps_url' => $o['gmaps_url'],
], $outlets), JSON_HEX_TAG | JSON_HEX_APOS);

// Pre-format every branch's hours (including main, key "0") so the JS
// doesn't need to duplicate fmt_time()'s logic.
$hours_by_outlet = $hours_by_outlet ?? [];
$hours_by_outlet_json = json_encode(array_map(
    fn($rows) => array_map(fn($h) => [
        'day_name'  => $h['day_name'],
        'is_closed' => $h['is_closed'],
        'time'      => $h['is_closed'] ? 'Closed' : fmt_time($h['open_time']) . ' – ' . fmt_time($h['close_time']),
    ], $rows),
    $hours_by_outlet
), JSON_HEX_TAG | JSON_HEX_APOS);

// Fallback (global settings) aside data
$global_address  = get_setting('address');
$global_map_url  = get_setting('map_url');
$global_phone    = get_setting('phone');
$global_email    = get_setting('email');
?>

<section class="page-hero">
    <div class="page-hero-bg"><img src="<?= e(url('assets/img/hero/book-hero.jpg')) ?>" alt="" aria-hidden="true"></div>
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
            <?php if ($errors): ?>
                <div class="alert err">Please check the highlighted fields and try again.</div>
            <?php endif; ?>

            <form method="post" action="<?= e(url('book')) ?>" novalidate>
                <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                <div class="form-grid">

                    <!-- Outlet picker — first for UX context -->
                    <div class="field full">
                        <label for="outlet_id">Which location? <span class="req">*</span></label>
                        <select id="outlet_id" name="outlet_id" data-outlet-picker required>
                            <option value="">Select a location…</option>
                            <?php foreach ($outlets as $o): ?>
                                <option value="<?= (int) $o['id'] ?>" <?= (string) $old['outlet_id'] === (string) $o['id'] ? 'selected' : '' ?>>
                                    <?= e($o['name']) ?> — <?= e($o['city']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['outlet_id'])): ?><span class="error-text"><?= e($errors['outlet_id']) ?></span><?php endif; ?>
                    </div>

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
                        <p class="form-note">We'll save your request and open WhatsApp so you can confirm with the studio in one tap.</p>
                    </div>
                </div>
            </form>
        </div>

        <aside class="book-aside reveal" style="--d:.1s" data-book-aside>
            <h3>Visit the studio</h3>

            <!-- Dynamic outlet info (shown when outlet is selected) -->
            <div data-aside-outlet style="display:none">
                <div class="aside-block">
                    <div class="lbl">Location</div>
                    <div class="val" data-aside-name></div>
                    <div class="val" data-aside-address style="margin-top:6px"></div>
                    <a class="val" data-aside-map href="#" target="_blank" rel="noopener" style="display:none">Get directions ↗</a>
                </div>
                <div class="aside-block" data-aside-phone-block style="display:none">
                    <div class="lbl">Phone</div>
                    <a class="val" data-aside-phone href="#"></a>
                </div>
                <!-- <div class="aside-block" data-aside-wa-block style="display:none">
                    <a class="btn btn-primary" data-aside-wa href="#" target="_blank" rel="noopener" style="width:100%;text-align:center">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp this outlet
                    </a>
                </div> -->
            </div>

            <!-- Fallback: global settings (shown when no outlet selected) -->
            <div data-aside-fallback>
                <div class="aside-block">
                    <div class="lbl">Where</div>
                    <div class="val"><?= $global_address ? nl2br(e($global_address)) : '—' ?></div>
                    <?php if ($global_map_url): ?><a class="val" href="<?= e($global_map_url) ?>" target="_blank" rel="noopener">Get directions ↗</a><?php endif; ?>
                </div>
                <div class="aside-block">
                    <div class="lbl">Get in touch</div>
                    <a class="val" href="tel:<?= e(preg_replace('/[^0-9+]/', '', $global_phone)) ?>"><?= e($global_phone) ?></a><br>
                    <a class="val" href="mailto:<?= e($global_email) ?>"><?= e($global_email) ?></a>
                </div>
            </div>

            <!-- Always shown -->
            <div class="aside-block">
                <div class="lbl">Opening hours</div>
                <div data-hours-list>
                    <?php foreach ($hours as $h): ?>
                        <div class="hours-row<?= $h['is_closed'] ? ' closed' : '' ?>">
                            <span class="d"><?= e($h['day_name']) ?></span>
                            <span class="t"><?= $h['is_closed'] ? 'Closed' : e(fmt_time($h['open_time']) . ' – ' . fmt_time($h['close_time'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="aside-block">
                <div class="lbl">Before you book</div>
                <a class="val" href="<?= e(url('faq')) ?>">Questions about appointments, colour or payment? See our FAQ →</a>
            </div>
        </aside>
    </div>
</section>

<script>
(function () {
  var outlets = <?= $outlets_json ?>;
  var hoursByOutlet = <?= $hours_by_outlet_json ?>;
  var picker  = document.querySelector('[data-outlet-picker]');
  var asideOutlet   = document.querySelector('[data-aside-outlet]');
  var asideFallback = document.querySelector('[data-aside-fallback]');
  var hoursList     = document.querySelector('[data-hours-list]');
  if (!picker || !asideOutlet) return;

  var elName    = document.querySelector('[data-aside-name]');
  var elAddr    = document.querySelector('[data-aside-address]');
  var elMap     = document.querySelector('[data-aside-map]');
  var elPhBlock = document.querySelector('[data-aside-phone-block]');
  var elPh      = document.querySelector('[data-aside-phone]');
  var elWaBlock = document.querySelector('[data-aside-wa-block]');
  var elWa      = document.querySelector('[data-aside-wa]');

  function renderHours(outletId) {
    if (!hoursList) return;
    var rows = hoursByOutlet[outletId] || hoursByOutlet[0] || [];
    hoursList.innerHTML = rows.map(function (h) {
      return '<div class="hours-row' + (h.is_closed ? ' closed' : '') + '">' +
               '<span class="d"></span><span class="t"></span>' +
             '</div>';
    }).join('');
    // Set text via textContent (not innerHTML) to keep this XSS-safe.
    hoursList.querySelectorAll('.hours-row').forEach(function (row, i) {
      row.querySelector('.d').textContent = rows[i].day_name;
      row.querySelector('.t').textContent = rows[i].time;
    });
  }

  function update() {
    var id = parseInt(picker.value, 10);
    var o  = outlets.find(function(x){ return x.id === id; });

    renderHours(o ? id : 0);

    if (!o) {
      asideOutlet.style.display   = 'none';
      asideFallback.style.display = '';
      return;
    }

    asideFallback.style.display = 'none';
    asideOutlet.style.display   = '';

    elName.textContent = o.name;
    elAddr.textContent = o.address;

    if (o.gmaps_url) {
      elMap.href = o.gmaps_url;
      elMap.style.display = '';
    } else {
      elMap.style.display = 'none';
    }

    if (o.phone) {
      elPh.textContent = o.phone;
      elPh.href = 'tel:' + o.phone.replace(/\s/g, '');
      elPhBlock.style.display = '';
    } else {
      elPhBlock.style.display = 'none';
    }

    if (o.whatsapp) {
      elWa.href = 'https://wa.me/' + o.whatsapp;
      elWaBlock.style.display = '';
    } else {
      elWaBlock.style.display = 'none';
    }
  }

  picker.addEventListener('change', update);
  update(); // run on load in case of re-submit with old value
})();
</script>