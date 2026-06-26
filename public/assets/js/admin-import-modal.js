/* ÉCLAT admin — outlet services import modal */
(function () {
  var modal  = document.getElementById('js-import-modal');
  if (!modal) return;
  var opens  = [document.getElementById('js-import-btn'), document.getElementById('js-import-btn2')];
  var closes = [document.getElementById('js-import-close'), document.getElementById('js-import-cancel'), document.getElementById('js-import-scrim')];
  opens.forEach(function (b)  { if (b) b.addEventListener('click', function () { modal.hidden = false; }); });
  closes.forEach(function (b) { if (b) b.addEventListener('click', function () { modal.hidden = true;  }); });
})();
