/**
 * NearTrips — Header: sticky scroll, mobile offcanvas, sub-menu a11y.
 */
(function () {
  'use strict';

  const header   = document.getElementById('nt-site-header');
  const toggle   = document.getElementById('nt-menu-toggle');
  const offcanvas= document.getElementById('nt-offcanvas');
  const closeBtn = document.getElementById('nt-offcanvas-close');
  const overlay  = document.getElementById('nt-overlay');

  /* ── Sticky header on scroll ── */
  let lastY = 0;
  let ticking = false;

  function onScroll() {
    lastY = window.scrollY;
    if (!ticking) {
      window.requestAnimationFrame(function () {
        if (!header) { ticking = false; return; }
        if (lastY > 80) {
          header.classList.add('is-sticky');
        } else {
          header.classList.remove('is-sticky');
        }
        ticking = false;
      });
      ticking = true;
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll(); /* run once on load */

  /* ── Offcanvas open ── */
  function openMenu() {
    if (!offcanvas || !overlay) return;
    offcanvas.classList.add('is-open');
    offcanvas.setAttribute('aria-hidden', 'false');
    overlay.classList.add('is-active');
    document.body.style.overflow = 'hidden';
    if (toggle) toggle.setAttribute('aria-expanded', 'true');
    /* Move focus into offcanvas */
    const first = offcanvas.querySelector('a, button');
    if (first) first.focus();
  }

  /* ── Offcanvas close ── */
  function closeMenu() {
    if (!offcanvas || !overlay) return;
    offcanvas.classList.remove('is-open');
    offcanvas.setAttribute('aria-hidden', 'true');
    overlay.classList.remove('is-active');
    document.body.style.overflow = '';
    if (toggle) {
      toggle.setAttribute('aria-expanded', 'false');
      toggle.focus();
    }
  }

  if (toggle)   toggle.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  if (overlay)  overlay.addEventListener('click', closeMenu);

  /* Escape key closes */
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  /* ── Mobile: accordion sub-menus ── */
  document.querySelectorAll('.nt-offcanvas-nav .menu-item-has-children > a').forEach(function (link) {
    const chevron = document.createElement('span');
    chevron.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6,9 12,15 18,9"/></svg>';
    chevron.style.cssText = 'display:flex;align-items:center;cursor:pointer;transition:transform .2s';
    link.appendChild(chevron);

    chevron.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      const sub = link.parentElement.querySelector('.sub-menu');
      if (!sub) return;
      const open = sub.classList.toggle('is-open');
      chevron.style.transform = open ? 'rotate(180deg)' : '';
    });
  });

  /* ── Desktop: keyboard accessible dropdowns ── */
  document.querySelectorAll('.nt-nav .menu-item-has-children').forEach(function (item) {
    item.addEventListener('focusout', function () {
      setTimeout(function () {
        if (!item.contains(document.activeElement)) {
          const sub = item.querySelector('.sub-menu');
          if (sub) { sub.style.opacity = ''; sub.style.visibility = ''; }
        }
      }, 150);
    });
  });
})();
