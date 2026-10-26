/* Optional decorative films: content never waits for remote media. */
(function () {
  'use strict';
  var videos = Array.prototype.slice.call(document.querySelectorAll('video[data-src]'));
  var toggle = document.querySelector('.motion-toggle');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
  var connection = navigator.connection;
  var paused = false;
  if (document.fonts && document.fonts.load) {
    document.fonts.load('400 16px Handjet').then(function (faces) {
      if (faces.length) document.documentElement.classList.add('fonts-ready');
    }).catch(function () {});
  }
  function disabled() { return reduce.matches || (connection && connection.saveData) || paused || document.hidden; }
  function sync(video) {
    if (disabled() || video.dataset.visible !== '1') { video.pause(); return; }
    if (!video.src) video.src = video.dataset.src;
    video.muted = true;
    var playing = video.play();
    if (playing && playing.catch) playing.catch(function () {});
  }
  function syncAll() {
    videos.forEach(sync);
    if (toggle) {
      toggle.hidden = !videos.length || reduce.matches || !!(connection && connection.saveData);
      toggle.textContent = paused ? 'Reproducir video' : 'Pausar video';
      toggle.setAttribute('aria-pressed', paused ? 'true' : 'false');
    }
  }
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        entry.target.dataset.visible = entry.isIntersecting ? '1' : '0';
        sync(entry.target);
      });
    }, { rootMargin: '120px 0px', threshold: 0.01 });
    videos.forEach(function (video) { observer.observe(video); });
  } else {
    // Keep the static backdrop when visibility observation is unavailable.
    videos.forEach(function (video) { video.dataset.visible = '0'; });
  }
  if (toggle) toggle.addEventListener('click', function () { paused = !paused; syncAll(); });
  document.addEventListener('visibilitychange', syncAll);
  if (reduce.addEventListener) reduce.addEventListener('change', syncAll);
  syncAll();
})();
