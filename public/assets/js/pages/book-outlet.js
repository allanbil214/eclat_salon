/* ÉCLAT — book page: dynamic aside update when outlet is selected.
   Depends on window.BOOK_DATA injected by the book.php view. */
(function () {
  var data = window.BOOK_DATA;
  if (!data) return;
  var outlets       = data.outlets;
  var hoursByOutlet = data.hoursByOutlet;

  var picker        = document.querySelector('[data-outlet-picker]');
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
    // Use textContent (not innerHTML) to stay XSS-safe.
    hoursList.querySelectorAll('.hours-row').forEach(function (row, i) {
      row.querySelector('.d').textContent = rows[i].day_name;
      row.querySelector('.t').textContent = rows[i].time;
    });
  }

  function update() {
    var id = parseInt(picker.value, 10);
    var o  = outlets.find(function (x) { return x.id === id; });

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
      elMap.href          = o.gmaps_url;
      elMap.style.display = '';
    } else {
      elMap.style.display = 'none';
    }

    if (o.phone) {
      elPh.textContent    = o.phone;
      elPh.href           = 'tel:' + o.phone.replace(/\s/g, '');
      elPhBlock.style.display = '';
    } else {
      elPhBlock.style.display = 'none';
    }

    if (elWa && o.whatsapp) {
      elWa.href = 'https://wa.me/' + o.whatsapp;
      if (elWaBlock) elWaBlock.style.display = '';
    } else if (elWaBlock) {
      elWaBlock.style.display = 'none';
    }
  }

  picker.addEventListener('change', update);
  update(); // run on load to handle re-submit with pre-selected value
})();
