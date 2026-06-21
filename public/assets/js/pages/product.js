/* Product detail: thumbnail switching + click-to-zoom lightbox. */
(function () {
  var main = document.getElementById('pd-main-img');
  if (!main) return;

  // Thumbnail → swap main image.
  document.querySelectorAll('.pd-thumb').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var full = btn.getAttribute('data-full');
      if (!full) return;
      main.src = full;
      document.querySelectorAll('.pd-thumb').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    });
  });

  // Lightbox.
  var box = document.createElement('div');
  box.className = 'pd-lightbox';
  box.innerHTML = '<span class="close" aria-hidden="true">&times;</span><img alt="">';
  document.body.appendChild(box);
  var boxImg = box.querySelector('img');

  main.addEventListener('click', function () {
    boxImg.src = main.src;
    box.classList.add('open');
  });
  box.addEventListener('click', function () { box.classList.remove('open'); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') box.classList.remove('open');
  });
})();
