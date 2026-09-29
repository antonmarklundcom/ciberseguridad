/* GA4 loader + events. Loaded only when GA4_ID is configured. The ID comes
   from data-ga on this script tag so no inline script is needed (strict CSP).
   Events: whatsapp_click, phone_click, generate_lead, assessment_*. */
(function () {
  'use strict';
  var tag = document.currentScript;
  var id = tag && tag.getAttribute('data-ga');
  if (!id || !/^G-[A-Z0-9]+$/.test(id)) return;

  window.dataLayer = window.dataLayer || [];
  window.gtag = function () { window.dataLayer.push(arguments); };
  window.gtag('js', new Date());
  window.gtag('config', id, { anonymize_ip: true });
  var s = document.createElement('script');
  s.async = true;
  s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
  document.head.appendChild(s);

  var body = document.body;
  function base() {
    return { page_path: location.pathname, service: body.getAttribute('data-service') || 'general' };
  }
  document.addEventListener('click', function (ev) {
    var a = ev.target.closest && ev.target.closest('a[href]');
    if (!a) return;
    var href = a.getAttribute('href') || '';
    if (href.indexOf('https://wa.me/') === 0) window.gtag('event', 'whatsapp_click', base());
    else if (href.indexOf('tel:') === 0) window.gtag('event', 'phone_click', base());
  });
  if (body.getAttribute('data-event') === 'generate_lead') {
    var p = base();
    p.form_type = new URLSearchParams(location.search).get('t') === 'autoevaluacion' ? 'autoevaluacion' : 'contacto';
    window.gtag('event', 'generate_lead', p);
  }
  window.addEventListener('assessment', function (ev) {
    var p = base();
    if (ev.detail && ev.detail.banda) p.banda = ev.detail.banda;
    window.gtag('event', 'assessment_' + ((ev.detail && ev.detail.step) || 'start'), p);
  });
})();
