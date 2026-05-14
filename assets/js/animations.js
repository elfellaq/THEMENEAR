/**
 * NearTrips — GSAP ScrollTrigger animations.
 * Requires gsap + ScrollTrigger loaded before this file.
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

  gsap.registerPlugin(ScrollTrigger);

  /* Skip if user prefers reduced motion */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    document.querySelectorAll('[data-anim]').forEach(function (el) {
      el.classList.add('is-animated');
    });
    return;
  }

  /* ── Fade-up: default for section heads, cards ── */
  gsap.utils.toArray('[data-anim="fade-up"]').forEach(function (el) {
    gsap.from(el, {
      y: 40,
      opacity: 0,
      duration: 0.8,
      ease: 'power2.out',
      scrollTrigger: {
        trigger: el,
        start: 'top 88%',
        toggleClass: { targets: el, className: 'is-animated' },
        once: true,
      },
    });
  });

  /* ── Stagger: card grids ── */
  gsap.utils.toArray('[data-anim="stagger"]').forEach(function (parent) {
    const children = parent.querySelectorAll('[data-anim-child]');
    if (!children.length) return;
    gsap.from(children, {
      y: 50,
      opacity: 0,
      duration: 0.7,
      ease: 'power2.out',
      stagger: 0.1,
      scrollTrigger: {
        trigger: parent,
        start: 'top 85%',
        once: true,
      },
    });
  });

  /* ── Scale-in: stat counters, icons ── */
  gsap.utils.toArray('[data-anim="scale-in"]').forEach(function (el) {
    gsap.from(el, {
      scale: 0.8,
      opacity: 0,
      duration: 0.6,
      ease: 'back.out(1.4)',
      scrollTrigger: {
        trigger: el,
        start: 'top 90%',
        once: true,
      },
    });
  });

  /* ── Slide-left / Slide-right ── */
  gsap.utils.toArray('[data-anim="slide-left"]').forEach(function (el) {
    gsap.from(el, {
      x: -60,
      opacity: 0,
      duration: 0.8,
      ease: 'power2.out',
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
    });
  });

  gsap.utils.toArray('[data-anim="slide-right"]').forEach(function (el) {
    gsap.from(el, {
      x: 60,
      opacity: 0,
      duration: 0.8,
      ease: 'power2.out',
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
    });
  });

  /* ── Number counter animation ── */
  gsap.utils.toArray('[data-count]').forEach(function (el) {
    const target = parseFloat(el.getAttribute('data-count'));
    const suffix = el.getAttribute('data-count-suffix') || '';
    gsap.from({ val: 0 }, {
      val: target,
      duration: 2,
      ease: 'power1.out',
      scrollTrigger: { trigger: el, start: 'top 85%', once: true },
      onUpdate: function () {
        el.textContent = Math.round(this.targets()[0].val).toLocaleString() + suffix;
      },
    });
  });

  /* ── Hero text reveal ── */
  const heroTitle = document.querySelector('.nt-hero__title');
  if (heroTitle) {
    gsap.from(heroTitle, { y: 60, opacity: 0, duration: 1, ease: 'power3.out', delay: 0.2 });
  }
  const heroSub = document.querySelector('.nt-hero__subtitle');
  if (heroSub) {
    gsap.from(heroSub, { y: 40, opacity: 0, duration: 0.9, ease: 'power2.out', delay: 0.5 });
  }
  const heroSearch = document.querySelector('.nt-search-widget');
  if (heroSearch) {
    gsap.from(heroSearch, { y: 50, opacity: 0, duration: 0.9, ease: 'power2.out', delay: 0.75 });
  }
});
