/* Self-assessment. Entirely client-side: nothing is sent anywhere until the
   visitor submits the optional contact form. State lives in memory only.
   Questions, weights and points come from data-* attributes on the server-
   rendered markup, so without JS the questions still read. */
(function () {
  'use strict';
  var root = document.getElementById('assess');
  if (!root) return;
  var qs = Array.prototype.slice.call(root.querySelectorAll('fieldset.q'));
  var nav = document.getElementById('assess-nav');
  var prev = document.getElementById('btn-prev');
  var next = document.getElementById('btn-next');
  var prog = document.getElementById('progress');
  var bar = document.getElementById('progress-bar');
  var label = document.getElementById('progress-label');
  var result = document.getElementById('result');
  var form = document.getElementById('questions');
  var cur = 0, started = false;

  function emit(step, banda) {
    try { window.dispatchEvent(new CustomEvent('assessment', { detail: { step: step, banda: banda } })); } catch (e) {}
  }
  function answered(i) { return !!qs[i].querySelector('input:checked'); }

  function show(i) {
    cur = i;
    qs.forEach(function (q, n) { q.classList.toggle('is-current', n === i); });
    label.textContent = 'Pregunta ' + (i + 1) + ' de ' + qs.length;
    var pct = Math.round((i / qs.length) * 100);
    bar.style.width = pct + '%';
    prog.querySelector('.progress').setAttribute('aria-valuenow', String(i));
    prev.disabled = i === 0;
    next.textContent = i === qs.length - 1 ? 'Ver mi resultado' : 'Siguiente';
    next.disabled = !answered(i);
    var first = qs[i].querySelector('input');
    if (first && started) { var c = qs[i].querySelector('input:checked') || first; c.focus(); }
  }

  function band(score) { return score < 40 ? 'alta' : (score < 70 ? 'media' : 'solida'); }
  var BAND_TEXT = {
    alta: ['Exposición alta', 'Según lo que indicaste, faltan varios controles básicos. Es un buen momento para ordenar las prioridades con alguien que conozca tu operación.'],
    media: ['Exposición media', 'Según lo que indicaste, lo básico existe y las brechas son puntuales. Conviene atender primero las áreas de abajo.'],
    solida: ['Base sólida declarada', 'Según lo que indicaste, los controles principales están en su lugar. El trabajo que sigue es de profundidad y de verificación.']
  };

  function compute() {
    var dom = {}, totPts = 0, totMax = 0;
    qs.forEach(function (q) {
      var d = q.getAttribute('data-domain');
      var w = parseInt(q.getAttribute('data-weight'), 10) || 1;
      var ch = q.querySelector('input:checked');
      var pts = ch ? parseInt(ch.getAttribute('data-pts'), 10) || 0 : 0;
      dom[d] = dom[d] || { p: 0, m: 0 };
      dom[d].p += pts * w; dom[d].m += 3 * w;
      totPts += pts * w; totMax += 3 * w;
    });
    var out = {};
    Object.keys(dom).forEach(function (d) { out[d] = Math.round(dom[d].p / dom[d].m * 100); });
    return { score: Math.round(totPts / totMax * 100), domains: out };
  }

  function el(tag, cls, text) {
    var n = document.createElement(tag);
    if (cls) n.className = cls;
    if (text) n.textContent = text;
    return n;
  }

  function finish() {
    var r = compute(), b = band(r.score);
    document.getElementById('result-score').textContent = String(r.score);
    document.getElementById('result-title').textContent = BAND_TEXT[b][0];
    document.getElementById('result-band').textContent = BAND_TEXT[b][1];

    var src = {}, labels = {};
    Array.prototype.forEach.call(document.querySelectorAll('#advice-source li'), function (li) {
      src[li.getAttribute('data-domain')] = li.textContent;
      labels[li.getAttribute('data-domain')] = li.getAttribute('data-label');
    });
    var box = document.getElementById('result-domains');
    box.textContent = '';
    var keys = Object.keys(r.domains);
    keys.forEach(function (d) {
      var row = el('div', 'bar-row');
      row.appendChild(el('span', '', labels[d] || d));
      row.appendChild(el('strong', '', r.domains[d] + ' / 100'));
      var track = el('div', 'bar-track');
      var fill = el('div', 'bar-fill');
      fill.style.width = r.domains[d] + '%';
      track.appendChild(fill); row.appendChild(track);
      box.appendChild(row);
    });
    var list = document.getElementById('result-actions');
    list.textContent = '';
    keys.slice().sort(function (a, c) { return r.domains[a] - r.domains[c]; }).slice(0, 3).forEach(function (d) {
      var li = el('li');
      li.appendChild(el('strong', '', (labels[d] || d) + '. '));
      li.appendChild(document.createTextNode(src[d] || ''));
      list.appendChild(li);
    });

    var f = result.querySelector('form.lead-form');
    if (f) {
      f.elements['score'].value = String(r.score);
      f.elements['banda'].value = b;
      f.elements['dominios'].value = JSON.stringify(r.domains);
      f.addEventListener('submit', function () { emit('submit', b); });
    }

    form.hidden = true; nav.hidden = true; prog.hidden = true;
    result.hidden = false;
    result.focus();
    emit('complete', b);
  }

  qs.forEach(function (q) {
    q.addEventListener('change', function () {
      if (!started) { started = true; emit('start'); }
      next.disabled = !answered(cur);
    });
  });
  prev.addEventListener('click', function () { if (cur > 0) show(cur - 1); });
  next.addEventListener('click', function () {
    if (!answered(cur)) return;
    if (cur < qs.length - 1) show(cur + 1); else finish();
  });
  var pb = document.getElementById('btn-print');
  if (pb) pb.addEventListener('click', function () { window.print(); });

  root.classList.add('is-live');
  nav.hidden = false; prog.hidden = false;
  show(0);
})();
