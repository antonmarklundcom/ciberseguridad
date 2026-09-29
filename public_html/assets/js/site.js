/* site.js — progressive enhancement only. The site reads and works without it.
   Nav toggle + focus trap, one fade-up reveal, form UX. No dependencies. */
(function () {
  'use strict';
  var d = document, root = d.documentElement;
  root.classList.add('js');

  /* ---- Nav ---- */
  var toggle = d.querySelector('.nav-toggle');
  var panel = d.getElementById('nav-panel');
  var header = d.querySelector('.site-header');
  var mq = window.matchMedia ? window.matchMedia('(max-width: 899px)') : null;

  function focusables() {
    return panel ? Array.prototype.slice.call(
      panel.querySelectorAll('a[href], button:not([disabled])')
    ).concat(toggle ? [toggle] : []) : [];
  }
  function setOpen(open) {
    if (!toggle || !header) return;
    header.classList.toggle('nav-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    d.body.style.overflow = open ? 'hidden' : '';
    if (open && panel) {
      var f = panel.querySelector('a[href]');
      if (f) f.focus();
    } else {
      toggle.focus();
    }
  }
  if (toggle && panel) {
    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    d.addEventListener('keydown', function (ev) {
      if (toggle.getAttribute('aria-expanded') !== 'true' || !mq || !mq.matches) return;
      if (ev.key === 'Escape') { setOpen(false); return; }
      if (ev.key !== 'Tab') return;
      var els = focusables();
      if (!els.length) return;
      var first = els[0], last = els[els.length - 1];
      if (ev.shiftKey && d.activeElement === first) { ev.preventDefault(); last.focus(); }
      else if (!ev.shiftKey && d.activeElement === last) { ev.preventDefault(); first.focus(); }
    });
    if (mq && mq.addEventListener) {
      mq.addEventListener('change', function () {
        if (!mq.matches) { header.classList.remove('nav-open'); toggle.setAttribute('aria-expanded', 'false'); d.body.style.overflow = ''; }
      });
    }
  }
  // Desktop dropdowns: click toggles too (hover/focus already handled in CSS).
  Array.prototype.forEach.call(d.querySelectorAll('.sub-toggle'), function (b) {
    b.addEventListener('click', function () {
      var open = b.getAttribute('aria-expanded') === 'true';
      Array.prototype.forEach.call(d.querySelectorAll('.sub-toggle'), function (o) { o.setAttribute('aria-expanded', 'false'); });
      b.setAttribute('aria-expanded', open ? 'false' : 'true');
    });
  });
  d.addEventListener('click', function (ev) {
    if (!ev.target.closest || ev.target.closest('.has-sub')) return;
    Array.prototype.forEach.call(d.querySelectorAll('.sub-toggle'), function (o) { o.setAttribute('aria-expanded', 'false'); });
  });

  /* ---- Reveal (fires once) ---- */
  var revealEls = d.querySelectorAll('.reveal');
  if (revealEls.length) {
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { en.target.classList.add('is-in'); io.unobserve(en.target); }
        });
      }, { rootMargin: '0px 0px -8% 0px' });
      Array.prototype.forEach.call(revealEls, function (el) { io.observe(el); });
    } else {
      Array.prototype.forEach.call(revealEls, function (el) { el.classList.add('is-in'); });
    }
  }

  /* ---- Forms: validate on blur, disable on submit, focus errors ---- */
  Array.prototype.forEach.call(d.querySelectorAll('form.lead-form'), function (form) {
    var msgs = { valueMissing: 'Completá este campo.', typeMismatch: 'Revisá el formato.' };
    function check(input) {
      if (!input.willValidate || input.name === 'website') return true;
      var id = 'err-' + input.name;
      var old = d.getElementById(id);
      if (old && !old.hasAttribute('data-server')) old.parentNode.removeChild(old);
      if (input.validity.valid) { input.removeAttribute('aria-invalid'); return true; }
      input.setAttribute('aria-invalid', 'true');
      if (!d.getElementById(id)) {
        var p = d.createElement('p');
        p.className = 'field-error'; p.id = id;
        p.textContent = input.validity.valueMissing ? msgs.valueMissing : msgs.typeMismatch;
        input.parentNode.appendChild(p);
        input.setAttribute('aria-describedby', id);
      }
      return false;
    }
    Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea'), function (i) {
      i.addEventListener('blur', function () { if (i.value !== '' || i.required) check(i); });
    });
    form.addEventListener('submit', function (ev) {
      var bad = null;
      Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea'), function (i) {
        if (!check(i) && !bad) bad = i;
      });
      if (bad) { ev.preventDefault(); bad.focus(); return; }
      var btn = form.querySelector('button[type=submit]');
      if (btn) { btn.disabled = true; btn.textContent = 'Enviando…'; }
    });
    var summary = form.querySelector('.form-errors');
    if (summary) summary.focus();
  });
})();
