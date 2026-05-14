/**
 * NearTrips — Swiper.js slider instances.
 * Requires Swiper v11 loaded before this script.
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  if (typeof Swiper === 'undefined') return;

  /* ── Hero Slider ── */
  if (document.querySelector('.nt-hero-swiper')) {
    new Swiper('.nt-hero-swiper', {
      loop: true,
      speed: 900,
      effect: 'fade',
      fadeEffect: { crossFade: true },
      autoplay: { delay: 6000, disableOnInteraction: false },
      pagination: {
        el: '.nt-hero-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.nt-hero-next',
        prevEl: '.nt-hero-prev',
      },
      a11y: {
        prevSlideMessage: 'Previous slide',
        nextSlideMessage: 'Next slide',
      },
    });
  }

  /* ── Featured Tours Slider ── */
  if (document.querySelector('.nt-tours-swiper')) {
    new Swiper('.nt-tours-swiper', {
      loop: false,
      speed: 600,
      spaceBetween: 24,
      grabCursor: true,
      navigation: {
        nextEl: '.nt-tours-next',
        prevEl: '.nt-tours-prev',
      },
      pagination: {
        el: '.nt-tours-pagination',
        clickable: true,
      },
      breakpoints: {
        0:    { slidesPerView: 1.1 },
        480:  { slidesPerView: 1.5 },
        768:  { slidesPerView: 2.2 },
        1024: { slidesPerView: 3 },
        1280: { slidesPerView: 3.5 },
      },
    });
  }

  /* ── Destinations Slider ── */
  if (document.querySelector('.nt-dest-swiper')) {
    new Swiper('.nt-dest-swiper', {
      loop: false,
      speed: 600,
      spaceBetween: 20,
      grabCursor: true,
      navigation: {
        nextEl: '.nt-dest-next',
        prevEl: '.nt-dest-prev',
      },
      breakpoints: {
        0:    { slidesPerView: 1.2 },
        480:  { slidesPerView: 2 },
        768:  { slidesPerView: 3 },
        1024: { slidesPerView: 4 },
        1280: { slidesPerView: 5 },
      },
    });
  }

  /* ── Testimonials Slider ── */
  if (document.querySelector('.nt-testimonials-swiper')) {
    new Swiper('.nt-testimonials-swiper', {
      loop: true,
      speed: 700,
      spaceBetween: 24,
      grabCursor: true,
      autoplay: { delay: 5000, disableOnInteraction: false },
      pagination: {
        el: '.nt-testimonials-pagination',
        clickable: true,
      },
      breakpoints: {
        0:   { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024:{ slidesPerView: 3 },
      },
    });
  }

  /* ── Single Tour Gallery ── */
  if (document.querySelector('.nt-gallery-thumbs')) {
    const thumbs = new Swiper('.nt-gallery-thumbs', {
      spaceBetween: 10,
      slidesPerView: 5,
      freeMode: true,
      watchSlidesProgress: true,
    });
    new Swiper('.nt-gallery-main', {
      spaceBetween: 0,
      thumbs: { swiper: thumbs },
      navigation: {
        nextEl: '.nt-gallery-next',
        prevEl: '.nt-gallery-prev',
      },
    });
  }
});
