/* Blog index: filter article cards by category. */
(function () {
  var buttons = document.querySelectorAll('.filter-bar button');
  var cards = document.querySelectorAll('.post-card');
  if (!buttons.length) return;
  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      buttons.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var cat = btn.getAttribute('data-filter');
      cards.forEach(function (c) {
        c.classList.toggle('hide', !(cat === 'all' || c.getAttribute('data-category') === cat));
      });
    });
  });
})();
