/* ciberseguridad.com.py — site.js
   Section 1: web-design-system/references/motion.js, copied verbatim.
   Section 2: analytics-prep.md shim, verbatim.
   Section 3: this site's own wiring (mobile nav, cookie banner) — no motion,
   no third-party requests. */

/* ---- 1. motion.js (verbatim) --------------------------------------------- */
(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var d = document;

  var items = d.querySelectorAll('[data-reveal]');
  if (reduce || !('IntersectionObserver' in window)) {
    items.forEach(function (el) { el.style.opacity = 1; el.style.transform = 'none'; });
  } else {
    items.forEach(function (el) {
      el.style.opacity = 0;
      el.style.transform = 'translateY(18px)';
      el.style.transition = 'opacity 280ms cubic-bezier(.16,1,.3,1), transform 280ms cubic-bezier(.16,1,.3,1)';
    });
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var i = Math.min(+(e.target.dataset.reveal || 0), 6);
        e.target.style.transitionDelay = (i * 70) + 'ms';
        e.target.style.opacity = 1;
        e.target.style.transform = 'none';
        io.unobserve(e.target);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.15 });
    items.forEach(function (el) { io.observe(el); });
  }

  var nums = d.querySelectorAll('[data-count]');
  if (nums.length && !reduce && 'IntersectionObserver' in window) {
    var nio = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var el = e.target, to = parseFloat(el.dataset.count), t0 = null;
        var suffix = el.dataset.countSuffix || '';
        function step(ts) {
          if (!t0) t0 = ts;
          var p = Math.min((ts - t0) / 900, 1);
          var eased = 1 - Math.pow(1 - p, 3);
          el.textContent = Math.round(to * eased).toLocaleString() + suffix;
          if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
        nio.unobserve(el);
      });
    }, { threshold: 0.5 });
    nums.forEach(function (el) { nio.observe(el); });
  }

  var hdr = d.querySelector('[data-sticky-header]');
  if (hdr) {
    var tick = false;
    window.addEventListener('scroll', function () {
      if (tick) return;
      tick = true;
      requestAnimationFrame(function () {
        hdr.classList.toggle('is-stuck', window.scrollY > 24);
        tick = false;
      });
    }, { passive: true });
  }
})();

/* ---- 2. analytics-prep.md shim (verbatim) --------------------------------- */
(function(){
  window.dataLayer = window.dataLayer || [];
  document.addEventListener('click', function(e){
    var t = e.target.closest('[data-ev]');
    if (!t) return;
    window.dataLayer.push({
      event: t.dataset.ev,
      ev_loc: t.dataset.evLoc || '',
      page_path: location.pathname,
      site: location.hostname
    });
  }, true);
})();

/* ---- 3. site wiring: mobile nav + cookie banner --------------------------- */
(function () {
  var d = document;

  var hamburger = d.querySelector('[data-mobile-open]');
  var panel = d.querySelector('[data-mobile-panel]');
  var close = d.querySelector('[data-mobile-close]');
  if (hamburger && panel) {
    hamburger.addEventListener('click', function () {
      panel.classList.add('is-open');
      panel.setAttribute('aria-hidden', 'false');
    });
  }
  if (close && panel) {
    close.addEventListener('click', function () {
      panel.classList.remove('is-open');
      panel.setAttribute('aria-hidden', 'true');
    });
  }

  // #agendar anchor (BUILD-SPEC.md §10 amendment 3): focuses the contact form
  // and preselects "llamada". No third-party booking embed — CSP forbids it.
  if (location.hash === '#agendar') {
    var pref = d.getElementById('preferencia_de_contacto');
    if (pref) { pref.value = 'llamada'; }
    var nombre = d.getElementById('nombre');
    if (nombre) { nombre.focus({ preventScroll: false }); }
  }

  var banner = d.querySelector('[data-cookie-banner]');
  if (banner) {
    var KEY = 'cb_consent';
    var has = false;
    try { has = document.cookie.indexOf(KEY + '=1') !== -1; } catch (e) {}
    if (!has) {
      banner.classList.add('is-visible');
    }
    var accept = banner.querySelector('[data-cookie-accept]');
    if (accept) {
      accept.addEventListener('click', function () {
        try {
          document.cookie = KEY + '=1; path=/; max-age=31536000; SameSite=Strict' +
            (location.protocol === 'https:' ? '; Secure' : '');
        } catch (e) {}
        banner.classList.remove('is-visible');
      });
    }
  }
})();
