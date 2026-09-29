/* Incident checklist: optional filtering to one path and print buttons.
   Without JS every path is visible and the browser's own print works. */
(function () {
  'use strict';
  var paths = Array.prototype.slice.call(document.querySelectorAll('.path'));
  var picks = Array.prototype.slice.call(document.querySelectorAll('#path-pick a'));
  if (!paths.length) return;

  function only(id) {
    paths.forEach(function (p) { p.classList.toggle('is-hidden', p.id !== id); });
    picks.forEach(function (a) {
      if (a.getAttribute('data-path') === id) a.setAttribute('aria-current', 'true');
      else a.removeAttribute('aria-current');
    });
  }
  picks.forEach(function (a) {
    a.addEventListener('click', function (ev) {
      ev.preventDefault();
      var id = a.getAttribute('data-path');
      only(id);
      var t = document.getElementById(id);
      if (t) { t.setAttribute('tabindex', '-1'); t.focus(); }
    });
  });
  var h = (location.hash || '').replace('#', '');
  if (h && document.getElementById(h) && picks.some(function (a) { return a.getAttribute('data-path') === h; })) only(h);

  function printMode(mode) {
    document.body.setAttribute('data-print', mode);
    window.print();
    document.body.removeAttribute('data-print');
  }
  var bl = document.getElementById('btn-print-list');
  var bs = document.getElementById('btn-print-sheet');
  if (bl) { bl.hidden = false; bl.addEventListener('click', function () { printMode('list'); }); }
  if (bs) { bs.hidden = false; bs.addEventListener('click', function () { printMode('sheet'); }); }
})();
