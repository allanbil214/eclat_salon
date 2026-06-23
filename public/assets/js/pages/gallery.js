/* Gallery: category filter + before/after drag reveal (with auto-preview loop). */
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
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('.ba').forEach(function (ba) {
    var handle = ba.querySelector('.handle');
    var dragging = false;
    var userDone = false;      // becomes true on first real interaction — auto-loop never returns
    var rafId = null;
    var startTs = 0;

    function setPos(clientX) {
      var rect = ba.getBoundingClientRect();
      var pct = ((clientX - rect.left) / rect.width) * 100;
      pct = Math.max(0, Math.min(100, pct));
      ba.style.setProperty('--pos', pct + '%');
    }

    /* auto-preview: gentle slow loop, eased via sine, until the user takes over */
    function loop(ts) {
      if (userDone) return;
      if (!startTs) startTs = ts;
      var elapsed = (ts - startTs) / 1000;
      var pos = 50 + 32 * Math.sin(elapsed * (Math.PI * 2) / 7);   // ~7s period, 18%–82%
      ba.style.setProperty('--pos', pos + '%');
      rafId = requestAnimationFrame(loop);
    }
    function autoStart() { if (userDone || reduceMotion || rafId) return; startTs = 0; rafId = requestAnimationFrame(loop); }
    function autoPause() { if (rafId) { cancelAnimationFrame(rafId); rafId = null; } }
    function autoStop() { userDone = true; autoPause(); }

    if (!reduceMotion) {
      if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
          entries.forEach(function (en) { if (en.isIntersecting) autoStart(); else autoPause(); });
        }, { threshold: 0.45 });
        io.observe(ba);
      } else {
        autoStart();
      }
    }

    function start(e) { autoStop(); dragging = true; setPos((e.touches ? e.touches[0] : e).clientX); }
    function move(e) { if (dragging) setPos((e.touches ? e.touches[0] : e).clientX); }
    function end() { dragging = false; }

    ba.addEventListener('mousedown', start);
    ba.addEventListener('touchstart', start, { passive: true });
    window.addEventListener('mousemove', move);
    window.addEventListener('touchmove', move, { passive: true });
    window.addEventListener('mouseup', end);
    window.addEventListener('touchend', end);

    if (handle) {
      handle.setAttribute('tabindex', '0');
      handle.setAttribute('role', 'slider');
      handle.addEventListener('keydown', function (e) {
        var cur = parseFloat(getComputedStyle(ba).getPropertyValue('--pos')) || 50;
        if (e.key === 'ArrowLeft')  { autoStop(); ba.style.setProperty('--pos', Math.max(0, cur - 4) + '%'); }
        if (e.key === 'ArrowRight') { autoStop(); ba.style.setProperty('--pos', Math.min(100, cur + 4) + '%'); }
      });
    }
  });
})();
