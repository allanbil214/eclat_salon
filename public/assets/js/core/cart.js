/* ÉCLAT cart — client-side (localStorage), hands off to WhatsApp at checkout. */
(function () {
  'use strict';
  var KEY = 'eclat_cart';

  /* ---- storage ---- */
  function read() {
    try { var v = JSON.parse(localStorage.getItem(KEY)); return Array.isArray(v) ? v : []; }
    catch (e) { return []; }
  }
  function write(cart) {
    try { localStorage.setItem(KEY, JSON.stringify(cart)); } catch (e) {}
    render();
  }
  function clear() { try { localStorage.removeItem(KEY); } catch (e) {} render(); }

  /* ---- helpers ---- */
  function money(n) { return 'Rp\u00A0' + new Intl.NumberFormat('id-ID').format(Math.round(n)); }
  function count(cart) { return cart.reduce(function (s, i) { return s + i.qty; }, 0); }
  function total(cart) { return cart.reduce(function (s, i) { return s + i.price * i.qty; }, 0); }
  function find(cart, id) { for (var i = 0; i < cart.length; i++) if (String(cart[i].id) === String(id)) return cart[i]; return null; }

  /* ---- mutations ---- */
  function add(item, qty) {
    var cart = read();
    var ex = find(cart, item.id);
    if (ex) { ex.qty = Math.min(99, ex.qty + qty); }
    else { cart.push({ id: item.id, slug: item.slug, name: item.name, brand: item.brand, price: item.price, image: item.image, qty: Math.min(99, qty) }); }
    write(cart);
  }
  function setQty(id, qty) {
    var cart = read(), it = find(cart, id);
    if (!it) return;
    it.qty = qty;
    if (it.qty < 1) cart = cart.filter(function (x) { return String(x.id) !== String(id); });
    write(cart);
  }
  function remove(id) { write(read().filter(function (x) { return String(x.id) !== String(id); })); }

  /* ---- rendering ---- */
  function rowHtml(it, big) {
    var line = money(it.price * it.qty);
    return '' +
      '<div class="ci' + (big ? ' ci--lg' : '') + '" data-ci="' + it.id + '">' +
        '<div class="ci-media">' + (it.image ? '<img src="' + it.image + '" alt="">' : '') + '</div>' +
        '<div class="ci-body">' +
          '<div class="ci-brand">' + (it.brand || '') + '</div>' +
          '<div class="ci-name">' + it.name + '</div>' +
          '<div class="ci-controls">' +
            '<div class="qty-stepper sm">' +
              '<button type="button" data-ci-dec aria-label="Decrease">\u2212</button>' +
              '<span data-ci-qty>' + it.qty + '</span>' +
              '<button type="button" data-ci-inc aria-label="Increase">+</button>' +
            '</div>' +
            '<button class="ci-remove" type="button" data-ci-remove aria-label="Remove">Remove</button>' +
          '</div>' +
        '</div>' +
        '<div class="ci-line">' + line + '</div>' +
      '</div>';
  }

  function paintInto(nodes, cart, big) {
    nodes.forEach(function (n) {
      n.innerHTML = cart.map(function (it) { return rowHtml(it, big); }).join('');
      n.querySelectorAll('[data-ci]').forEach(function (row) {
        var id = row.getAttribute('data-ci');
        row.querySelector('[data-ci-inc]').addEventListener('click', function () { var it = find(read(), id); if (it) setQty(id, it.qty + 1); });
        row.querySelector('[data-ci-dec]').addEventListener('click', function () { var it = find(read(), id); if (it) setQty(id, it.qty - 1); });
        row.querySelector('[data-ci-remove]').addEventListener('click', function () { remove(id); });
      });
    });
  }

  function render() {
    var cart = read(), c = count(cart), empty = cart.length === 0;

    document.querySelectorAll('[data-cart-count]').forEach(function (b) {
      b.textContent = c; b.hidden = c === 0;
    });
    document.querySelectorAll('[data-cart-count-text]').forEach(function (t) { t.textContent = c; });
    document.querySelectorAll('[data-cart-total]').forEach(function (t) { t.textContent = money(total(cart)); });

    paintInto(Array.prototype.slice.call(document.querySelectorAll('[data-cart-drawer-items]')), cart, false);
    paintInto(Array.prototype.slice.call(document.querySelectorAll('[data-cart-page-items]')), cart, true);

    document.querySelectorAll('[data-cart-empty-state]').forEach(function (n) { n.hidden = !empty; });
    document.querySelectorAll('[data-cart-foot]').forEach(function (n) { n.hidden = empty; });
    document.querySelectorAll('[data-cart-drawer-items]').forEach(function (n) { n.hidden = empty; });
    document.querySelectorAll('[data-cart-page-items]').forEach(function (n) { n.hidden = empty; });
    document.querySelectorAll('[data-cart-checkout]').forEach(function (n) { n.style.display = empty ? 'none' : ''; });

    var submit = document.querySelector('[data-cart-submit]');
    if (submit) submit.disabled = empty;

    // keep the hidden checkout field in sync
    var json = document.querySelector('[data-cart-json]');
    if (json) json.value = JSON.stringify(read());
  }

  /* ---- drawer open/close ---- */
  function openDrawer() {
    var d = document.querySelector('[data-cart-drawer]');
    if (!d) return;
    d.classList.add('open'); d.setAttribute('aria-hidden', 'false');
    document.body.classList.add('cart-open');
  }
  function closeDrawer() {
    var d = document.querySelector('[data-cart-drawer]');
    if (!d) return;
    d.classList.remove('open'); d.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('cart-open');
  }

  /* ---- wire up ---- */
  document.addEventListener('click', function (e) {
    var addBtn = e.target.closest('[data-add-to-cart]');
    if (addBtn) {
      var qty = 1;
      if (addBtn.hasAttribute('data-from-qty')) {
        var box = addBtn.closest('.pd-info') || document;
        var inp = box.querySelector('[data-qty-input]');
        qty = Math.max(1, Math.min(99, parseInt(inp && inp.value, 10) || 1));
      }
      add({
        id: addBtn.getAttribute('data-id'),
        slug: addBtn.getAttribute('data-slug'),
        name: addBtn.getAttribute('data-name'),
        brand: addBtn.getAttribute('data-brand'),
        price: parseFloat(addBtn.getAttribute('data-price')) || 0,
        image: addBtn.getAttribute('data-image')
      }, qty);
      var label = addBtn.textContent;
      addBtn.classList.add('added'); addBtn.textContent = 'Added \u2713';
      setTimeout(function () { addBtn.classList.remove('added'); addBtn.textContent = label; }, 1100);
      openDrawer();
      return;
    }
    if (e.target.closest('[data-cart-open]')) { e.preventDefault(); openDrawer(); return; }
    if (e.target.closest('[data-cart-close]')) { closeDrawer(); return; }
  });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeDrawer(); });

  /* product-page quantity stepper */
  document.querySelectorAll('[data-qty]').forEach(function (box) {
    var inp = box.querySelector('[data-qty-input]');
    function setv(v) { inp.value = Math.max(1, Math.min(99, v || 1)); }
    box.querySelector('[data-qty-inc]').addEventListener('click', function () { setv((parseInt(inp.value, 10) || 1) + 1); });
    box.querySelector('[data-qty-dec]').addEventListener('click', function () { setv((parseInt(inp.value, 10) || 1) - 1); });
    inp.addEventListener('input', function () { inp.value = inp.value.replace(/[^0-9]/g, ''); });
    inp.addEventListener('blur', function () { setv(parseInt(inp.value, 10)); });
  });

  /* checkout: keep hidden field current + address-required hint */
  var form = document.querySelector('.cart-form');
  if (form) {
    form.addEventListener('submit', function () {
      var json = form.querySelector('[data-cart-json]');
      if (json) json.value = JSON.stringify(read());
    });
    var ff = form.querySelectorAll('[name="fulfillment"]');
    var addrReq = form.querySelector('[data-addr-req]');
    ff.forEach(function (r) {
      r.addEventListener('change', function () {
        if (addrReq) addrReq.hidden = form.querySelector('[name="fulfillment"]:checked').value !== 'delivery';
      });
    });
  }

  /* confirmation page: order placed → empty the cart */
  if (document.querySelector('[data-clear-cart]')) { clear(); }

  render();
})();
