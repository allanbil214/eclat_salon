/* ÉCLAT dashboard — minor enhancements. */
(function () {
  // Auto-dismiss flash messages after a few seconds.
  setTimeout(function () {
    document.querySelectorAll('.adm-flash--ok').forEach(function (el) {
      el.style.transition = 'opacity .4s'; el.style.opacity = '0';
      setTimeout(function () { el.remove(); }, 400);
    });
  }, 3500);
})();

/* Theme toggle (persisted in a cookie; server renders it on next load). */
(function () {
  var btn = document.querySelector('[data-adm-theme-toggle]');
  if (!btn) return;
  btn.addEventListener('click', function () {
    var html = document.documentElement;
    var next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    document.cookie = 'adm_theme=' + next + ';path=/;max-age=31536000;samesite=lax';
  });
})();
