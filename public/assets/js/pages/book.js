/* Book page: stop past dates being picked. */
(function () {
  var date = document.querySelector('#preferred_date');
  if (date) {
    date.setAttribute('min', new Date().toISOString().split('T')[0]);
  }
})();
