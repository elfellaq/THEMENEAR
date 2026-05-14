/**
 * NearTrips — Dark Mode
 * Reads/writes localStorage, applies data-theme to <html>.
 */
(function () {
  'use strict';

  const ROOT    = document.documentElement;
  const STORAGE = 'nt_theme';
  const BTN     = document.getElementById('nt-dark-toggle');

  function applyTheme(theme) {
    ROOT.setAttribute('data-theme', theme);
    if (!BTN) return;
    const sun  = BTN.querySelector('.nt-icon-sun');
    const moon = BTN.querySelector('.nt-icon-moon');
    if (theme === 'dark') {
      if (sun)  sun.style.display  = 'none';
      if (moon) moon.style.display = '';
    } else {
      if (sun)  sun.style.display  = '';
      if (moon) moon.style.display = 'none';
    }
  }

  function getPreferred() {
    const stored = localStorage.getItem(STORAGE);
    if (stored) return stored;
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  function toggle() {
    const next = ROOT.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    localStorage.setItem(STORAGE, next);
    applyTheme(next);
  }

  /* Apply on load immediately to avoid FOUC */
  applyTheme(getPreferred());

  document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('nt-dark-toggle');
    if (btn) btn.addEventListener('click', toggle);
    /* Re-apply in case DOM wasn't ready on first call */
    applyTheme(getPreferred());
  });

  /* Sync across tabs */
  window.addEventListener('storage', function (e) {
    if (e.key === STORAGE) applyTheme(e.newValue || 'light');
  });
})();
