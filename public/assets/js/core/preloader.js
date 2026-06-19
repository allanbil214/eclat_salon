/* Hide the preloader once the page (and fonts) have loaded. */
(function () {
  var pre = document.querySelector('.preloader');
  if (!pre) return;
  function hide() { pre.classList.add('loaded'); }
  if (document.readyState === 'complete') { setTimeout(hide, 350); }
  else { window.addEventListener('load', function () { setTimeout(hide, 350); }); }
  // safety net
  setTimeout(hide, 2500);
})();
