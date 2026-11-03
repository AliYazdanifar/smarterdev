/* SmarterDev — shared interactions: theme toggle, sticky header, mobile drawer, FAQ accordion, scroll reveal. */
(function () {
  'use strict';
  var root = document.documentElement;
  var qs = function (s, c) { return (c || document).querySelector(s); };
  var qsa = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---- Theme toggle -------------------------------------------------- */
  var THEME_COLORS = { dark: '#080B12', light: '#F6F8FC' };
  function applyTheme(theme, persist) {
    root.setAttribute('data-theme', theme);
    root.setAttribute('data-bs-theme', theme);
    if (persist) { try { localStorage.setItem('sd-theme', theme); } catch (e) { /* ignore */ } }
    var meta = qs('meta[name="theme-color"]');
    if (meta) { meta.setAttribute('content', THEME_COLORS[theme]); }
    qsa('[data-theme-toggle]').forEach(function (btn) {
      btn.setAttribute('aria-label', theme === 'dark' ? 'تغییر به تم روشن' : 'تغییر به تم تیره');
      btn.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
    });
  }
  applyTheme(root.getAttribute('data-theme') || 'dark', false);
  qsa('[data-theme-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark', true);
    });
  });

  /* ---- Header scroll state + mobile CTA bar -------------------------- */
  var header = qs('#site-header');
  var mobileCta = qs('[data-mobile-cta]');
  var ticking = false;
  function onScroll() {
    var y = window.pageYOffset || root.scrollTop;
    if (header) { header.classList.toggle('is-scrolled', y > 8); }
    if (mobileCta) { mobileCta.classList.toggle('is-visible', y > 520); }
    ticking = false;
  }
  window.addEventListener('scroll', function () {
    if (!ticking) { ticking = true; window.requestAnimationFrame(onScroll); }
  }, { passive: true });
  onScroll();

  /* ---- Mobile drawer (overlay, slide, Esc, scroll lock, focus trap) --- */
  var drawer = qs('#mobile-drawer');
  var overlay = qs('[data-drawer-overlay]');
  var openers = qsa('[data-drawer-open]');
  var lastFocus = null;
  var FOCUSABLE = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';

  function setDrawer(open) {
    if (!drawer) { return; }
    drawer.classList.toggle('is-open', open);
    if (overlay) { overlay.classList.toggle('is-open', open); }
    root.classList.toggle('has-drawer', open);
    openers.forEach(function (b) { b.setAttribute('aria-expanded', open ? 'true' : 'false'); });
    if (open) {
      lastFocus = document.activeElement;
      window.setTimeout(function () { var first = qs(FOCUSABLE, drawer); if (first) { first.focus(); } }, 60);
    } else if (lastFocus) {
      lastFocus.focus();
    }
  }
  openers.forEach(function (b) { b.addEventListener('click', function () { setDrawer(true); }); });
  qsa('[data-drawer-close]').forEach(function (b) { b.addEventListener('click', function () { setDrawer(false); }); });
  if (overlay) { overlay.addEventListener('click', function () { setDrawer(false); }); }
  if (drawer) {
    qsa('a', drawer).forEach(function (a) { a.addEventListener('click', function () { setDrawer(false); }); });
    drawer.addEventListener('keydown', function (e) {
      if (e.key !== 'Tab') { return; }
      var items = qsa(FOCUSABLE, drawer);
      if (!items.length) { return; }
      var first = items[0], last = items[items.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && drawer && drawer.classList.contains('is-open')) { setDrawer(false); }
  });
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 992 && drawer && drawer.classList.contains('is-open')) { setDrawer(false); }
  });

  /* ---- FAQ accordion (all answers stay in the DOM / readable without JS) */
  qsa('.faq-item').forEach(function (item) {
    var btn = qs('.faq-btn', item);
    if (!btn) { return; }
    btn.setAttribute('aria-expanded', 'false');
    btn.addEventListener('click', function () {
      var open = !item.classList.contains('is-open');
      item.classList.toggle('is-open', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  /* ---- Scroll reveal ------------------------------------------------- */
  var reveals = qsa('.reveal');
  if ('IntersectionObserver' in window && reveals.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('is-visible'); io.unobserve(en.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
    reveals.forEach(function (el) {
      var d = el.getAttribute('data-delay');
      if (d) { el.style.setProperty('--d', d + 's'); }
      io.observe(el);
    });
  } else {
    reveals.forEach(function (el) { el.classList.add('is-visible'); });
  }
})();
