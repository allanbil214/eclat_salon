/* ÉCLAT admin — "check all" toggle for team assignment table */
(function () {
  var all = document.getElementById('js-check-all');
  if (!all) return;
  var cbs = document.querySelectorAll('.js-member-cb');
  all.addEventListener('change', function () {
    cbs.forEach(function (cb) { cb.checked = all.checked; });
  });
  cbs.forEach(function (cb) {
    cb.addEventListener('change', function () {
      var checked = Array.from(cbs).filter(function (c) { return c.checked; }).length;
      all.indeterminate = checked > 0 && checked < cbs.length;
      all.checked       = checked === cbs.length;
    });
  });
})();
