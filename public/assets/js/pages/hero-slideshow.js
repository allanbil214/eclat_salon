/* Hero slideshow — cross-fade, fixed text, dot indicators. */
(function () {
  'use strict';

  const INTERVAL = 5500; // ms between transitions
  const FADE_DUR = 1200; // must match CSS transition duration

  function init() {
    const track = document.querySelector('.hero-slides');
    if (!track) return; // single-image hero, nothing to do

    const slides = Array.from(track.querySelectorAll('.hero-slide'));
    if (slides.length < 2) return;

    const dotsWrap = document.querySelector('.hero-dots');
    const dots = dotsWrap ? Array.from(dotsWrap.querySelectorAll('.hero-dot')) : [];

    let current = 0;
    let timer = null;

    function goTo(index) {
      slides[current].classList.remove('is-active');
      dots[current]?.classList.remove('is-active');
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('is-active');
      dots[current]?.classList.add('is-active');
    }

    function next() { goTo(current + 1); }

    function start() { timer = setInterval(next, INTERVAL); }
    function stop()  { clearInterval(timer); }

    // Pause on hover for accessibility
    const hero = document.querySelector('.hero');
    hero?.addEventListener('mouseenter', stop);
    hero?.addEventListener('mouseleave', start);

    // Dot click
    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => { stop(); goTo(i); start(); });
    });

    // Kick off
    slides[0].classList.add('is-active');
    dots[0]?.classList.add('is-active');
    start();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
