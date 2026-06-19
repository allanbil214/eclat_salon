/* Book form niceties: stop past dates being picked. */
(function () {
  var date = document.querySelector('#preferred_date');
  if (date) {
    var today = new Date().toISOString().split('T')[0];
    date.setAttribute('min', today);
  }
})();
