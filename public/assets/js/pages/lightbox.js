/* Lightbox — gallery (filter-aware, prev/next, BA slider) + home lookbook (standalone). */
(function () {
  'use strict';

  /* ------------------------------------------------------------------ */
  /* Helpers                                                              */
  /* ------------------------------------------------------------------ */

  function cloneBA(sourceBa) {
    var clone = sourceBa.cloneNode(true);
    clone.style.setProperty('--pos', '50%');
    return clone;
  }

  function initBASlider(ba) {
    var handle = ba.querySelector('.handle');
    if (!handle) return;
    var dragging = false;

    function setPos(clientX) {
      var rect = ba.getBoundingClientRect();
      var pct = ((clientX - rect.left) / rect.width) * 100;
      ba.style.setProperty('--pos', Math.max(0, Math.min(100, pct)) + '%');
    }

    handle.addEventListener('pointerdown', function (e) {
      e.preventDefault();
      dragging = true;
      try { handle.setPointerCapture(e.pointerId); } catch (_) {}
      setPos(e.clientX);
    });
    handle.addEventListener('pointermove', function (e) { if (dragging) setPos(e.clientX); });
    function release(e) {
      if (!dragging) return;
      dragging = false;
      try { handle.releasePointerCapture(e.pointerId); } catch (_) {}
    }
    handle.addEventListener('pointerup', release);
    handle.addEventListener('pointercancel', release);

    handle.setAttribute('tabindex', '0');
    handle.setAttribute('role', 'slider');
    handle.addEventListener('keydown', function (e) {
      var cur = parseFloat(ba.style.getPropertyValue('--pos')) || 50;
      if (e.key === 'ArrowLeft')  ba.style.setProperty('--pos', Math.max(0,   cur - 4) + '%');
      if (e.key === 'ArrowRight') ba.style.setProperty('--pos', Math.min(100, cur + 4) + '%');
    });
  }

  /* ------------------------------------------------------------------ */
  /* Build lightbox DOM (once)                                            */
  /* ------------------------------------------------------------------ */

  var lb = document.createElement('div');
  lb.className = 'lb';
  lb.setAttribute('role', 'dialog');
  lb.setAttribute('aria-modal', 'true');
  lb.setAttribute('aria-label', 'Image viewer');

  var closeBtn = document.createElement('button');
  closeBtn.className = 'lb-close';
  closeBtn.setAttribute('aria-label', 'Close');
  closeBtn.innerHTML = '&times;';

  var prevBtn = document.createElement('button');
  prevBtn.className = 'lb-prev';
  prevBtn.setAttribute('aria-label', 'Previous');
  prevBtn.innerHTML = '&#8249;';

  var nextBtn = document.createElement('button');
  nextBtn.className = 'lb-next';
  nextBtn.setAttribute('aria-label', 'Next');
  nextBtn.innerHTML = '&#8250;';

  var counter = document.createElement('div');
  counter.className = 'lb-counter';

  var stage = document.createElement('div');
  stage.className = 'lb-stage';

  /* media wraps only the visual — caption lives outside so clearing media
     never detaches caption from the DOM */
  var media = document.createElement('div');
  media.className = 'lb-media';

  var caption = document.createElement('div');
  caption.className = 'lb-caption';

  stage.appendChild(media);
  stage.appendChild(caption);
  lb.appendChild(closeBtn);
  lb.appendChild(prevBtn);
  lb.appendChild(nextBtn);
  lb.appendChild(counter);
  lb.appendChild(stage);
  document.body.appendChild(lb);

  /* ------------------------------------------------------------------ */
  /* State                                                                */
  /* ------------------------------------------------------------------ */

  var set       = [];
  var idx       = 0;
  var isOpen    = false;
  var lastFocus = null;

  /* ------------------------------------------------------------------ */
  /* Open / close                                                         */
  /* ------------------------------------------------------------------ */

  function open(tiles, startIdx) {
    set       = tiles;
    idx       = startIdx;
    lastFocus = document.activeElement;
    render(idx, false);
    lb.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    isOpen = true;
    closeBtn.focus();
  }

  function close() {
    lb.classList.remove('is-open');
    document.body.style.overflow = '';
    isOpen = false;
    /* Safe clear — media no longer contains caption */
    media.innerHTML = '';
    caption.textContent = '';
    if (lastFocus) lastFocus.focus();
  }

  /* ------------------------------------------------------------------ */
  /* Render a slide                                                       */
  /* ------------------------------------------------------------------ */

  function render(i, animate) {
    var tile = set[i];

    function populate() {
      media.innerHTML = '';

      var ba = tile.querySelector('.ba');
      if (ba) {
        var clone = cloneBA(ba);
        media.appendChild(clone);
        initBASlider(clone);
      } else {
        var src = tile.querySelector('img');
        var img = document.createElement('img');
        img.className = 'lb-img';
        img.src = src ? src.src : '';
        img.alt = src ? (src.alt || '') : '';
        media.appendChild(img);
      }

      /* Caption */
      var ttl = tile.querySelector('.ttl, .t');
      var by  = tile.querySelector('.by,  .b');
      caption.textContent = ttl ? ttl.textContent + (by ? ' \u00b7 ' + by.textContent : '') : '';

      /* Prev / next */
      prevBtn.hidden = (set.length <= 1);
      nextBtn.hidden = (set.length <= 1);

      /* Counter */
      if (set.length > 1) {
        counter.textContent = (i + 1) + ' / ' + set.length;
        counter.style.display = '';
      } else {
        counter.style.display = 'none';
      }

      if (animate) {
        media.classList.remove('is-fading');
        media.classList.add('is-visible');
      }
    }

    if (animate) {
      media.classList.add('is-fading');
      media.classList.remove('is-visible');
      setTimeout(populate, 180);
    } else {
      populate();
    }
  }

  /* ------------------------------------------------------------------ */
  /* Navigate                                                             */
  /* ------------------------------------------------------------------ */

  function go(delta) {
    idx = (idx + delta + set.length) % set.length;
    render(idx, true);
  }

  prevBtn.addEventListener('click', function () { go(-1); });
  nextBtn.addEventListener('click', function () { go(1); });

  lb.addEventListener('click', function (e) {
    if (e.target === lb || e.target === stage) close();
  });
  closeBtn.addEventListener('click', close);

  document.addEventListener('keydown', function (e) {
    if (!isOpen) return;
    if (e.key === 'Escape')     close();
    if (e.key === 'ArrowRight') go(1);
    if (e.key === 'ArrowLeft')  go(-1);
  });

  /* ------------------------------------------------------------------ */
  /* Gallery page — filter-aware prev/next                               */
  /* ------------------------------------------------------------------ */

  var galleryTiles = document.querySelectorAll('.masonry .tile[data-lightbox]');

  if (galleryTiles.length) {
    function visibleTiles() {
      return Array.prototype.filter.call(
        document.querySelectorAll('.masonry .tile[data-lightbox]'),
        function (t) { return !t.classList.contains('hide'); }
      );
    }

    galleryTiles.forEach(function (tile) {
      tile.style.cursor = 'zoom-in';
      tile.addEventListener('click', function (e) {
        if (e.target.closest('.handle')) return;
        var visible = visibleTiles();
        var i = visible.indexOf(tile);
        open(visible, i === -1 ? 0 : i);
      });
    });
  }

})();;
