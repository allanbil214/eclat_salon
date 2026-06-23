/* ÉCLAT dashboard — form helpers: image modal, gallery, Quill, auto-slug. */
(function () {
  'use strict';

  function meta(n) { var m = document.querySelector('meta[name="' + n + '"]'); return m ? m.getAttribute('content') : ''; }
  var uploadUrl = meta('upload-url');
  var csrf = meta('csrf');

  /* ---------- shared image modal ---------- */
  var modal = document.querySelector('[data-img-modal]');
  var onPick = null;

  function resetModal() {
    if (!modal) return;
    var up = modal.querySelector('[data-tab="upload"]');
    if (up) up.click();
    var s = modal.querySelector('[data-upload-status]');
    if (s) { s.textContent = ''; s.className = 'adm-upload-status'; }
    var u = modal.querySelector('[data-url-input]');
    if (u) u.value = '';
  }
  function openModal(cb) { onPick = cb; if (modal) { resetModal(); modal.hidden = false; } }
  function closeModal() { if (modal) modal.hidden = true; onPick = null; }

  if (modal) {
    modal.querySelectorAll('[data-tab]').forEach(function (t) {
      t.addEventListener('click', function () {
        modal.querySelectorAll('[data-tab]').forEach(function (x) { x.classList.remove('on'); });
        t.classList.add('on');
        var name = t.getAttribute('data-tab');
        modal.querySelectorAll('[data-tabpane]').forEach(function (p) { p.hidden = p.getAttribute('data-tabpane') !== name; });
      });
    });
    modal.querySelectorAll('[data-img-cancel]').forEach(function (c) { c.addEventListener('click', closeModal); });

    var fileInput = modal.querySelector('[data-file]');
    var status = modal.querySelector('[data-upload-status]');
    if (fileInput) fileInput.addEventListener('change', function () {
      var file = fileInput.files[0];
      if (!file) return;
      status.textContent = 'Uploading…'; status.className = 'adm-upload-status';
      var fd = new FormData();
      fd.append('_csrf', csrf);
      fd.append('file', file);
      fetch(uploadUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (d && d.ok) { if (onPick) onPick(d.path, d.url); closeModal(); }
          else { status.textContent = (d && d.error) || 'Upload failed.'; status.className = 'adm-upload-status err'; }
        })
        .catch(function () { status.textContent = 'Upload failed.'; status.className = 'adm-upload-status err'; });
      fileInput.value = '';
    });

    var urlInput = modal.querySelector('[data-url-input]');
    var urlUse = modal.querySelector('[data-url-use]');
    if (urlUse) urlUse.addEventListener('click', function () {
      var v = (urlInput.value || '').trim();
      if (!v) return;
      if (onPick) onPick(v, v);
      closeModal();
    });
  }

  /* ---------- single image field ---------- */
  document.querySelectorAll('[data-imgfield]').forEach(function (field) {
    var input = field.querySelector('[data-imgfield-input]');
    var preview = field.querySelector('.adm-imgfield-preview');
    var pick = field.querySelector('[data-img-pick]');
    var clear = field.querySelector('[data-img-clear]');
    if (pick) pick.addEventListener('click', function () {
      openModal(function (path, disp) { input.value = path; preview.innerHTML = '<img src="' + disp + '" alt="">'; });
    });
    if (clear) clear.addEventListener('click', function () { input.value = ''; preview.innerHTML = ''; });
  });

  /* ---------- gallery field ---------- */
  document.querySelectorAll('[data-gallery]').forEach(function (g) {
    var list = g.querySelector('[data-gallery-list]');
    var tpl = document.querySelector('[data-gallery-template]');
    var add = g.querySelector('[data-gallery-add]');
    if (add && tpl) add.addEventListener('click', function () {
      openModal(function (path, disp) {
        var node = tpl.content.firstElementChild.cloneNode(true);
        node.querySelector('img').src = disp;
        node.querySelector('input').value = path;
        list.appendChild(node);
      });
    });
    if (list) list.addEventListener('click', function (e) {
      var item = e.target.closest('[data-gallery-item]');
      if (!item) return;
      if (e.target.closest('[data-g-remove]')) item.remove();
      else if (e.target.closest('[data-g-up]') && item.previousElementSibling) list.insertBefore(item, item.previousElementSibling);
      else if (e.target.closest('[data-g-down]') && item.nextElementSibling) list.insertBefore(item.nextElementSibling, item);
    });
  });

  /* ---------- auto-slug (any form with data-slug-src + data-slug-out) ---------- */
  function slugify(s) { return (s || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, ''); }
  document.querySelectorAll('[data-slug-src]').forEach(function (src) {
    var form = src.closest('form');
    var out = form ? form.querySelector('[data-slug-out]') : null;
    if (!out) return;
    var edited = out.value.trim() !== '';
    out.addEventListener('input', function () { edited = out.value.trim() !== ''; });
    src.addEventListener('input', function () { if (!edited) out.value = slugify(src.value); });
  });

  /* ---------- Quill rich text ---------- */
  if (typeof Quill !== 'undefined') {
    document.querySelectorAll('[data-quill]').forEach(function (el) {
      var target = document.getElementById(el.getAttribute('data-target'));
      var q = new Quill(el, {
        theme: 'snow',
        modules: { toolbar: [[{ header: [2, 3, false] }], ['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['blockquote', 'link'], ['clean']] }
      });
      var form = el.closest('form');
      if (form && target) form.addEventListener('submit', function () { target.value = q.root.innerHTML; });
    });
  }
})();
