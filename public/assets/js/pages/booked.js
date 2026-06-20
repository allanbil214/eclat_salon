/* Confirmation page: count down, then open WhatsApp in a new tab.
   (The button is the guaranteed fallback if the browser blocks the pop-up.) */
(function () {
  var box = document.querySelector('.booked-countdown[data-wa]');
  if (!box) return;
  var url  = box.getAttribute('data-wa');
  var secsEl = box.querySelector('[data-count-secs]');
  var secs = 5;

  var timer = setInterval(function () {
    secs -= 1;
    if (secsEl) secsEl.textContent = secs;
    if (secs <= 0) {
      clearInterval(timer);
      if (secsEl) box.innerHTML = 'Opening WhatsApp\u2026';
      // Try a new tab; if blocked, the on-page button still works.
      window.open(url, '_blank', 'noopener');
    }
  }, 1000);
})();
