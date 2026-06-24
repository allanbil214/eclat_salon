/* Gallery: category filter + before/after (handle-only drag, auto-loop w/ idle resume) + home carousel. */
(function () {
  /* ---- Filter (gallery page) ---- */
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
  var IDLE_MS = 5000;

  document.querySelectorAll('.ba').forEach(function (ba) {
    var handle = ba.querySelector('.handle');
    if (!handle) return;
    var dragging = false, rafId = null, startTs = 0, idleTimer = null, inView = false;

    function setPos(clientX) {
      var rect = ba.getBoundingClientRect();
      var pct = ((clientX - rect.left) / rect.width) * 100;
      ba.style.setProperty('--pos', Math.max(0, Math.min(100, pct)) + '%');
    }

    function loop(ts) {
      if (!startTs) startTs = ts;
      var t = (ts - startTs) / 1000;
      ba.style.setProperty('--pos', (50 + 32 * Math.sin(t * (Math.PI * 2) / 7)) + '%');
      rafId = requestAnimationFrame(loop);
    }
    function autoStart() { if (reduceMotion || rafId || dragging || !inView) return; startTs = 0; rafId = requestAnimationFrame(loop); }
    function autoStop()  { if (rafId) { cancelAnimationFrame(rafId); rafId = null; } }
    function scheduleResume() { clearTimeout(idleTimer); idleTimer = setTimeout(autoStart, IDLE_MS); }
    function interrupt() { autoStop(); clearTimeout(idleTimer); }

    // visibility drives the auto-loop
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          inView = en.isIntersecting;
          if (inView) autoStart(); else interrupt();
        });
      }, { threshold: 0.45 }).observe(ba);
    } else { inView = true; autoStart(); }

    // drag — handle only, so the image area stays scrollable on touch
    handle.addEventListener('pointerdown', function (e) {
      e.preventDefault();
      interrupt(); dragging = true;
      try { handle.setPointerCapture(e.pointerId); } catch (_) {}
      setPos(e.clientX);
    });
    handle.addEventListener('pointermove', function (e) { if (dragging) setPos(e.clientX); });
    function release(e) { if (!dragging) return; dragging = false; try { handle.releasePointerCapture(e.pointerId); } catch (_) {} scheduleResume(); }
    handle.addEventListener('pointerup', release);
    handle.addEventListener('pointercancel', release);

    handle.setAttribute('tabindex', '0');
    handle.setAttribute('role', 'slider');
    handle.addEventListener('keydown', function (e) {
      var cur = parseFloat(getComputedStyle(ba).getPropertyValue('--pos')) || 50;
      if (e.key === 'ArrowLeft')  { interrupt(); ba.style.setProperty('--pos', Math.max(0, cur - 4) + '%'); scheduleResume(); }
      if (e.key === 'ArrowRight') { interrupt(); ba.style.setProperty('--pos', Math.min(100, cur + 4) + '%'); scheduleResume(); }
    });
  });

  /* ---- Home carousel (when more than 3 transformations) ---- */
  document.querySelectorAll('[data-ba-carousel]').forEach(function (car) {
    var track = car.querySelector('.ba-track');
    if (!track) return;
    function step() {
      var slide = track.querySelector('.ba-slide');
      return slide ? slide.getBoundingClientRect().width + 24 : track.clientWidth * 0.8;
    }
    var prev = car.querySelector('[data-ba-prev]');
    var next = car.querySelector('[data-ba-next]');
    if (prev) prev.addEventListener('click', function () { track.scrollBy({ left: -step(), behavior: 'smooth' }); });
    if (next) next.addEventListener('click', function () { track.scrollBy({ left: step(), behavior: 'smooth' }); });
  });
})();
