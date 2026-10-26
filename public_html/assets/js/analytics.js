/* Optional GA4 funnel measurement. Intent events are not acceptance/delivery receipts.
   Never include field values, query strings, full referrers or destination contacts.
   Disabled unless the owner configures GA4_ID; existing consent/configuration policy applies. */
(function () {
  'use strict';
  var tag = document.currentScript;
  var id = tag && tag.getAttribute('data-ga');
  if (!id || !/^G-[A-Z0-9]+$/.test(id)) return;
  var body = document.body;
  var slug = body.getAttribute('data-page') || '404';
  var path = slug === 'home' ? '/' : '/' + slug + '/';
  // The server supplies a registry slug. Refuse malformed context in a modified DOM.
  if (!/^(?:\/|\/[a-z0-9-]+(?:\/[a-z0-9-]+)*\/)$/.test(path)) return;
  var service = body.getAttribute('data-service') || 'general';
  if (!/^[a-z0-9-]+$/.test(service)) service = 'general';

  window.dataLayer = window.dataLayer || [];
  window.gtag = function () { window.dataLayer.push(arguments); };
  window.gtag('js', new Date());
  window.gtag('config', id, {
    anonymize_ip: true,
    send_page_view: false,
    page_location: location.origin + path,
    page_referrer: '',
    allow_google_signals: false,
    allow_ad_personalization_signals: false
  });
  function base() { return { page_path: path, service: service }; }
  window.gtag('event', 'page_view', base());
  var s = document.createElement('script');
  s.async = true;
  s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(id);
  document.head.appendChild(s);

  document.addEventListener('click', function (ev) {
    var a = ev.target.closest && ev.target.closest('a[href]');
    if (!a) return;
    var href = a.getAttribute('href') || '';
    if (/^\/encontra-un-proveedor\/(?:[?#]|$)/.test(href)) window.gtag('event', 'orientation_click', base());
    else if (href.indexOf('https://wa.me/') === 0) window.gtag('event', 'whatsapp_click', base());
    else if (href.indexOf('tel:') === 0) window.gtag('event', 'phone_click', base());
  });
  Array.prototype.forEach.call(document.querySelectorAll('form.lead-form'), function (form) {
    var started = false;
    function start(ev) {
      if (started || !ev.target || !/^(INPUT|SELECT|TEXTAREA)$/.test(ev.target.tagName)
          || ev.target.type === 'hidden' || ev.target.name === 'website') return;
      started = true;
      var p = base(); p.form_type = 'orientacion';
      window.gtag('event', 'orientation_start', p);
    }
    form.addEventListener('input', start);
    form.addEventListener('change', start);
    form.addEventListener('submit', function (ev) {
      if (ev.defaultPrevented || !form.checkValidity()) return;
      var p = base(); p.form_type = 'orientacion';
      window.gtag('event', 'orientation_submit', p);
    });
  });
  // Do not emit generate_lead on /gracias/: direct visits and bot redirects
  // are indistinguishable from accepted requests here. Accepted/delivered
  // counts remain in the private recording/outbox, not in this browser event.
})();
