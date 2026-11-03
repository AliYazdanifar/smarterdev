/* Runs synchronously in <head> (before first paint) to avoid a flash of the wrong theme.
   Dark is the default. A saved choice always wins. System preference is opt-in (see flag). */
(function () {
  'use strict';
  var FOLLOW_SYSTEM_WHEN_NO_SAVED_CHOICE = false; // set true to let prefers-color-scheme: light apply on first visit
  var root = document.documentElement;
  var theme = 'dark';
  try {
    var saved = localStorage.getItem('sd-theme');
    if (saved === 'light' || saved === 'dark') {
      theme = saved;
    } else if (FOLLOW_SYSTEM_WHEN_NO_SAVED_CHOICE && window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
      theme = 'light';
    }
  } catch (e) { /* storage unavailable: keep default */ }
  root.setAttribute('data-theme', theme);
  root.setAttribute('data-bs-theme', theme);
  root.classList.add('js');
})();
