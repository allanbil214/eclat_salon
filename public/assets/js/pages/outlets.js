/* Outlets carousel — drag/swipe + prev/next buttons. */
(function () {
  'use strict';

  function init() {
    const wrap  = document.querySelector('[data-outlets-track]');
    if (!wrap) return;

    const cards   = Array.from(wrap.children);
    const total   = cards.length;
    if (total <= 3) return; // grid-like, no scroll needed

    const btnPrev = document.querySelector('[data-outlets-prev]');
    const btnNext = document.querySelector('[data-outlets-next]');

    let current = 0;

    function cardWidth() {
      return cards[0].getBoundingClientRect().width + 24; // gap = 24px
    }

    function go(dir) {
      current = Math.max(0, Math.min(current + dir, total - 3));
      wrap.style.transform = 'translateX(-' + (current * cardWidth()) + 'px)';
      if (btnPrev) btnPrev.disabled = current === 0;
      if (btnNext) btnNext.disabled = current >= total - 3;
    }

    btnPrev?.addEventListener('click', () => go(-1));
    btnNext?.addEventListener('click', () => go(1));

    // Touch / swipe
    let startX = 0;
    wrap.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    wrap.addEventListener('touchend',   e => {
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 40) go(dx < 0 ? 1 : -1);
    });

    go(0); // init button states
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
