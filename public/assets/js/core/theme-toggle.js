/* Theme toggle. The server already rendered the right theme from a cookie
   (no flash), so this just flips the attribute and remembers the choice. */
(function () {
  var btn = document.querySelector('.theme-toggle');
  if (!btn) return;
  btn.addEventListener('click', function () {
    var root = document.documentElement;
    var next = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    root.setAttribute('data-theme', next);
    // persist for one year
    document.cookie = 'theme=' + next + ';path=/;max-age=31536000;samesite=lax';
    btn.setAttribute('aria-label', next === 'light' ? 'Switch to dark mode' : 'Switch to light mode');
  });
})();
