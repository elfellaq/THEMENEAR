/**
 * NearTrips — Search Widget + AJAX live search.
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  /* ── Tab switching ── */
  const tabBtns  = document.querySelectorAll('[data-search-tab]');
  const tabPanes = document.querySelectorAll('[data-search-pane]');

  tabBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const target = btn.getAttribute('data-search-tab');

      tabBtns.forEach(function (b) {
        b.classList.remove('is-active');
        b.setAttribute('aria-selected', 'false');
      });
      tabPanes.forEach(function (p) { p.style.display = 'none'; });

      btn.classList.add('is-active');
      btn.setAttribute('aria-selected', 'true');

      const pane = document.querySelector('[data-search-pane="' + target + '"]');
      if (pane) pane.style.display = '';
    });
  });

  /* Activate first tab on load */
  if (tabBtns.length) tabBtns[0].click();

  /* ── flatpickr date pickers ── */
  if (typeof flatpickr !== 'undefined') {
    document.querySelectorAll('.nt-datepicker').forEach(function (el) {
      flatpickr(el, {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        disableMobile: false,
      });
    });
    document.querySelectorAll('.nt-datepicker-range').forEach(function (el) {
      flatpickr(el, {
        mode: 'range',
        dateFormat: 'Y-m-d',
        minDate: 'today',
      });
    });
  }

  /* ── AJAX Live Search (header bar) ── */
  const liveInput   = document.getElementById('nt-live-search');
  const liveResults = document.getElementById('nt-live-results');
  if (!liveInput || !liveResults || typeof ntConfig === 'undefined') return;

  let debounceTimer;

  liveInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    const q = liveInput.value.trim();
    if (q.length < 2) { liveResults.innerHTML = ''; liveResults.hidden = true; return; }

    debounceTimer = setTimeout(function () {
      liveResults.innerHTML = '<div class="nt-spinner" style="margin:16px auto"></div>';
      liveResults.hidden = false;

      const fd = new FormData();
      fd.append('action', 'nt_live_search');
      fd.append('q', q);
      fd.append('nonce', ntConfig.nonce);

      fetch(ntConfig.ajaxUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (!data.success || !data.data.length) {
            liveResults.innerHTML = '<p class="nt-live-empty">' + ntConfig.i18n.noResults + '</p>';
            return;
          }
          liveResults.innerHTML = data.data.map(function (item) {
            return '<a class="nt-live-item" href="' + item.url + '">' +
              '<img src="' + item.thumb + '" alt="" width="48" height="48" loading="lazy">' +
              '<div><strong>' + item.title + '</strong><span>' + item.type + '</span></div>' +
              '</a>';
          }).join('');
        })
        .catch(function () {
          liveResults.innerHTML = '<p class="nt-live-empty">' + ntConfig.i18n.noResults + '</p>';
        });
    }, 320);
  });

  /* Close results on outside click */
  document.addEventListener('click', function (e) {
    if (!liveInput.contains(e.target) && !liveResults.contains(e.target)) {
      liveResults.hidden = true;
    }
  });

  /* ── Main search form submission ── */
  const searchForm = document.getElementById('nt-search-form');
  if (searchForm) {
    searchForm.addEventListener('submit', function (e) {
      const activePane = searchForm.querySelector('[data-search-pane]:not([style*="none"])');
      if (!activePane) return;
      const postType = activePane.getAttribute('data-post-type') || 'nt_tour';
      const hidden   = searchForm.querySelector('input[name="post_type"]');
      if (hidden) hidden.value = postType;
    });
  }
});
