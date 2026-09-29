/* First-touch attribution (VenderCRM). Stores UTM/click-ids in the vc_attr
   cookie once; the PHP handler reads it defensively. See
   docs/VENDERCRM_INTEGRATION.md. */
(function () {
  'use strict';
  try {
    if (document.cookie.indexOf('vc_attr=') !== -1) return;
    var keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'gclid', 'fbclid'];
    var params = new URLSearchParams(window.location.search);
    var data = {}, any = false;
    keys.forEach(function (k) {
      var v = params.get(k);
      if (v) { data[k] = v.slice(0, 200); any = true; }
    });
    if (!any) return;
    var val = encodeURIComponent(JSON.stringify(data));
    if (val.length > 1800) return;
    document.cookie = 'vc_attr=' + val + '; Max-Age=' + (60 * 60 * 24 * 90) + '; Path=/; SameSite=Lax' +
      (location.protocol === 'https:' ? '; Secure' : '');
  } catch (e) { /* never break the page for attribution */ }
})();
