/**
 * Travelio main script.
 * - Mobile menu toggle
 * - Sticky header on scroll
 * - Tour single-page tab switching
 * - Animated stat counters
 */
(function () {
  'use strict';

  // Mobile nav toggle
  var toggle = document.querySelector('.tv-menu-toggle');
  var nav = document.getElementById('tv-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Sticky header
  var header = document.getElementById('tv-site-header');
  if (header) {
    var onScroll = function () {
      if (window.scrollY > 80) header.classList.add('is-sticky');
      else header.classList.remove('is-sticky');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Tour single tabs
  var tabBtns = document.querySelectorAll('.tv-tour-tabs button');
  if (tabBtns.length) {
    tabBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var name = btn.dataset.tab;
        tabBtns.forEach(function (b) { b.classList.remove('is-active'); });
        btn.classList.add('is-active');
        document.querySelectorAll('.tv-tour-panel').forEach(function (p) {
          p.classList.toggle('is-active', p.dataset.panel === name);
        });
      });
    });
  }

  // Animated counters
  var nums = document.querySelectorAll('.tv-stat-num');
  if (nums.length && 'IntersectionObserver' in window) {
    var animate = function (el) {
      var raw = el.textContent.trim();
      var match = raw.match(/^(\d+(?:\.\d+)?)(.*)$/);
      if (!match) return;
      var target = parseFloat(match[1]);
      var suffix = match[2];
      var start = 0;
      var duration = 1200;
      var startTime = null;
      function step(ts) {
        if (!startTime) startTime = ts;
        var p = Math.min((ts - startTime) / duration, 1);
        var v = start + (target - start) * (1 - Math.pow(1 - p, 3));
        el.textContent = (target >= 100 ? Math.round(v) : v.toFixed(1)) + suffix;
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          animate(e.target);
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.3 });
    nums.forEach(function (n) { io.observe(n); });
  }
})();
