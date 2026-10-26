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
  var servicesMenu = d.getElementById('services-menu');
  var servicesSummary = servicesMenu ? servicesMenu.querySelector('summary') : null;
  var mq = window.matchMedia ? window.matchMedia('(max-width: 1150px)') : null;

  function focusables() {
    return panel ? (toggle ? [toggle] : []).concat(Array.prototype.slice.call(
      panel.querySelectorAll('a[href], button:not([disabled]), summary')
    ).filter(function (el) { return el.getClientRects().length > 0; })) : [];
  }
  function setOpen(open) {
    if (!toggle || !header) return;
    header.classList.toggle('nav-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    d.body.classList.toggle('menu-open', open);
    if (open && panel) {
      var f = focusables()[1];
      if (f) f.focus();
    } else {
      if (servicesMenu) servicesMenu.open = false;
      toggle.focus();
    }
  }
  if (toggle && panel) {
    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    d.addEventListener('keydown', function (ev) {
      if (ev.key === 'Escape' && servicesMenu && servicesMenu.open) {
        ev.preventDefault(); servicesMenu.open = false;
        if (servicesSummary) servicesSummary.focus();
        return;
      }
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
        if (!mq.matches) { header.classList.remove('nav-open'); toggle.setAttribute('aria-expanded', 'false'); d.body.classList.remove('menu-open'); }
      });
    }
  }
  // Native details keeps all service links usable without JavaScript.
  // Enhancement adds predictable outside-click/focus and Escape dismissal.
  d.addEventListener('click', function (ev) {
    if (servicesMenu && servicesMenu.open && !servicesMenu.contains(ev.target)) servicesMenu.open = false;
  });
  d.addEventListener('focusin', function (ev) {
    if (servicesMenu && servicesMenu.open && !servicesMenu.contains(ev.target)) servicesMenu.open = false;
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
    var msgs = { valueMissing: 'Completá este campo.', typeMismatch: 'Revisá el formato.', patternMismatch: 'Revisá el formato. Para teléfono usá números, espacios, +, paréntesis o guiones.', tooShort: 'Completá al menos la cantidad mínima de caracteres.' };
    function check(input) {
      if (!input.willValidate || input.name === 'website') return true;
      var id = 'err-' + input.name;
      var old = d.getElementById(id);
      if (old) old.parentNode.removeChild(old);
      if (input.validity.valid) { input.removeAttribute('aria-invalid'); input.removeAttribute('aria-describedby'); return true; }
      input.setAttribute('aria-invalid', 'true');
      if (!d.getElementById(id)) {
        var p = d.createElement('p');
        p.className = 'field-error'; p.id = id;
        p.textContent = input.validity.valueMissing ? msgs.valueMissing : input.validity.patternMismatch ? msgs.patternMismatch : input.validity.tooShort ? msgs.tooShort : msgs.typeMismatch;
        input.parentNode.appendChild(p);
        input.setAttribute('aria-describedby', id);
      }
      return false;
    }
    Array.prototype.forEach.call(form.querySelectorAll('input, select, textarea'), function (i) {
      i.addEventListener('blur', function () { if (i.value !== '' || i.required) check(i); });
    });
    var submitButton = form.querySelector('button[type=submit]');
    var submitLabel = submitButton ? submitButton.textContent : '';
    window.addEventListener('pageshow', function () {
      if (submitButton) { submitButton.disabled = false; submitButton.textContent = submitLabel; }
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
  Array.prototype.forEach.call(d.querySelectorAll('.print-brief'), function (button) {
    button.addEventListener('click', function () { window.print(); });
  });
  /* Service catalog filtering: every card remains available without JS. */
  var chips = d.querySelectorAll('[data-filter]');
  Array.prototype.forEach.call(chips, function (chip) {
    chip.setAttribute('aria-pressed', chip.classList.contains('active') ? 'true' : 'false');
    chip.addEventListener('click', function () {
      var category = chip.getAttribute('data-filter');
      Array.prototype.forEach.call(chips, function (c) {
        c.classList.toggle('active', c === chip);
        c.setAttribute('aria-pressed', c === chip ? 'true' : 'false');
      });
      Array.prototype.forEach.call(d.querySelectorAll('.service-card[data-category]'), function (card) {
        card.hidden = category !== 'all' && card.getAttribute('data-category') !== category;
      });
    });
  });
})();
