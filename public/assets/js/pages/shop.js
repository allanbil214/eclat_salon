/* Shop: filter products by brand. */
(function () {
  var buttons = document.querySelectorAll('.filter-bar button');
  var cards = document.querySelectorAll('.product-card');
  if (!buttons.length) return;
  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      buttons.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var brand = btn.getAttribute('data-filter');
      cards.forEach(function (c) {
        var show = brand === 'all' || c.getAttribute('data-brand') === brand;
        c.classList.toggle('hide', !show);
      });
    });
  });
})();
