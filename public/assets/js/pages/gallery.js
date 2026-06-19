/* Gallery: category filter + before/after drag reveal. */
(function () {
  /* ---- Filter ---- */
  var buttons = document.querySelectorAll('.filter-bar button');
  var tiles = document.querySelectorAll('.masonry .tile');
  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      buttons.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var cat = btn.getAttribute('data-filter');
      tiles.forEach(function (t) {
        var show = cat === 'all' || t.getAttribute('data-category') === cat;
        t.classList.toggle('hide', !show);
      });
    });
  });

  /* ---- Before / after sliders ---- */
  document.querySelectorAll('.ba').forEach(function (ba) {
    var handle = ba.querySelector('.handle');
    var dragging = false;

    function setPos(clientX) {
      var rect = ba.getBoundingClientRect();
      var pct = ((clientX - rect.left) / rect.width) * 100;
      pct = Math.max(0, Math.min(100, pct));
      ba.style.setProperty('--pos', pct + '%');
    }
    function start(e) { dragging = true; setPos((e.touches ? e.touches[0] : e).clientX); }
    function move(e) { if (dragging) setPos((e.touches ? e.touches[0] : e).clientX); }
    function end() { dragging = false; }

    ba.addEventListener('mousedown', start);
    ba.addEventListener('touchstart', start, { passive: true });
    window.addEventListener('mousemove', move);
    window.addEventListener('touchmove', move, { passive: true });
    window.addEventListener('mouseup', end);
    window.addEventListener('touchend', end);

    // keyboard support on the handle
    if (handle) {
      handle.setAttribute('tabindex', '0');
      handle.setAttribute('role', 'slider');
      handle.addEventListener('keydown', function (e) {
        var cur = parseFloat(getComputedStyle(ba).getPropertyValue('--pos')) || 50;
        if (e.key === 'ArrowLeft') ba.style.setProperty('--pos', Math.max(0, cur - 4) + '%');
        if (e.key === 'ArrowRight') ba.style.setProperty('--pos', Math.min(100, cur + 4) + '%');
      });
    }
  });
})();
