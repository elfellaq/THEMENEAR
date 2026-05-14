/**
 * NearTrips — Main JS entry point.
 * Initialises all minor UI pieces not handled by dedicated modules.
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  /* ── Lazy-load images via IntersectionObserver ── */
  if ('IntersectionObserver' in window) {
    const lazyImgs = document.querySelectorAll('img[data-src]');
    const imgObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        const img = entry.target;
        img.src = img.getAttribute('data-src');
        if (img.getAttribute('data-srcset')) {
          img.srcset = img.getAttribute('data-srcset');
        }
        img.removeAttribute('data-src');
        img.removeAttribute('data-srcset');
        imgObserver.unobserve(img);
      });
    }, { rootMargin: '200px' });
    lazyImgs.forEach(function (img) { imgObserver.observe(img); });
  }

  /* ── Wishlist / heart toggle ── */
  document.querySelectorAll('[data-wishlist-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      btn.classList.toggle('is-active');
      const icon = btn.querySelector('svg');
      if (icon) {
        icon.setAttribute('fill', btn.classList.contains('is-active') ? 'var(--nt-primary)' : 'none');
      }
    });
  });

  /* ── Back to top ── */
  const backTop = document.getElementById('nt-back-top');
  if (backTop) {
    window.addEventListener('scroll', function () {
      backTop.hidden = window.scrollY < 400;
    }, { passive: true });
    backTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ── Smooth scroll anchor links ── */
  document.querySelectorAll('a[href^="#"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      const id = a.getAttribute('href').slice(1);
      if (!id) return;
      const target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  /* ── Accordion / FAQ ── */
  document.querySelectorAll('.nt-accordion-toggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const item    = btn.closest('.nt-accordion-item');
      const content = item ? item.querySelector('.nt-accordion-content') : null;
      const isOpen  = item && item.classList.contains('is-open');

      const parent = btn.closest('.nt-accordion');
      if (parent) {
        parent.querySelectorAll('.nt-accordion-item.is-open').forEach(function (other) {
          other.classList.remove('is-open');
          const c = other.querySelector('.nt-accordion-content');
          if (c) c.style.maxHeight = '0';
        });
      }

      if (!isOpen && item && content) {
        item.classList.add('is-open');
        content.style.maxHeight = content.scrollHeight + 'px';
      }
    });
  });

  /* ── Tab panels (single page) ── */
  document.querySelectorAll('.nt-tabs').forEach(function (tabs) {
    const btns   = tabs.querySelectorAll('.nt-tab-btn');
    const panels = document.querySelectorAll('.nt-tab-panel');

    btns.forEach(function (btn, i) {
      btn.addEventListener('click', function () {
        btns.forEach(function (b, j) {
          b.classList.toggle('is-active', j === i);
          b.setAttribute('aria-selected', j === i ? 'true' : 'false');
        });
        panels.forEach(function (p, j) {
          p.hidden = j !== i;
        });
      });
    });

    if (btns.length) btns[0].click();
  });

  /* ── Review star picker ── */
  document.querySelectorAll('.nt-review-stars').forEach(function (group) {
    const stars = group.querySelectorAll('[data-star]');
    const input = group.parentElement ? group.parentElement.querySelector('input[name]') : null;

    stars.forEach(function (star, idx) {
      star.addEventListener('mouseover', function () {
        stars.forEach(function (s, j) {
          s.setAttribute('fill', j <= idx ? 'var(--nt-yellow)' : 'none');
        });
      });
      star.addEventListener('mouseleave', function () {
        const val = input ? parseInt(input.value || '0', 10) : 0;
        stars.forEach(function (s, j) {
          s.setAttribute('fill', j < val ? 'var(--nt-yellow)' : 'none');
        });
      });
      star.addEventListener('click', function () {
        if (input) input.value = idx + 1;
        stars.forEach(function (s, j) {
          s.setAttribute('fill', j <= idx ? 'var(--nt-yellow)' : 'none');
        });
      });
    });
  });

  /* ── Animated stat counters ── */
  const statNums = document.querySelectorAll('[data-count]');
  if (statNums.length && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        const el     = entry.target;
        const target = parseFloat(el.getAttribute('data-count'));
        const suffix = el.getAttribute('data-count-suffix') || '';
        let start = 0;
        const dur = 1800;
        let startTime = null;
        function step(ts) {
          if (!startTime) startTime = ts;
          const p = Math.min((ts - startTime) / dur, 1);
          const v = target * (1 - Math.pow(1 - p, 3));
          el.textContent = Math.round(v).toLocaleString() + suffix;
          if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
        io.unobserve(el);
      });
    }, { threshold: 0.3 });
    statNums.forEach(function (n) { io.observe(n); });
  }
});
