/**
 * NearTrips — Booking Widget Logic.
 * Multi-step: Date → Time → Qty → Total → Checkout
 */
document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  const widget = document.getElementById('nt-booking-widget');
  if (!widget) return;

  /* ── flatpickr on booking date ── */
  if (typeof flatpickr !== 'undefined') {
    const dateInput = widget.querySelector('.nt-booking-date');
    if (dateInput) {
      flatpickr(dateInput, {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: function (dates, dateStr) {
          widget.querySelector('input[name="booking_date"]').value = dateStr;
          updateTotal();
        },
      });
    }
  }

  /* ── Qty stepper ── */
  widget.querySelectorAll('.nt-qty-input').forEach(function (input) {
    const dec = input.previousElementSibling;
    const inc = input.nextElementSibling;
    const min = parseInt(input.getAttribute('min') || '0', 10);
    const max = parseInt(input.getAttribute('max') || '99', 10);

    function clamp(v) { return Math.max(min, Math.min(max, v)); }

    if (dec) dec.addEventListener('click', function () {
      input.value = clamp(parseInt(input.value || '0', 10) - 1);
      updateTotal();
    });
    if (inc) inc.addEventListener('click', function () {
      input.value = clamp(parseInt(input.value || '0', 10) + 1);
      updateTotal();
    });
    input.addEventListener('change', function () {
      input.value = clamp(parseInt(input.value || '0', 10));
      updateTotal();
    });
  });

  /* ── Price calculation ── */
  function updateTotal() {
    const priceEl = widget.querySelector('[data-unit-price]');
    const totalEl = widget.querySelector('.nt-booking-total-value');
    if (!priceEl || !totalEl) return;

    const unitPrice = parseFloat(priceEl.getAttribute('data-unit-price') || '0');
    let qty = 0;
    widget.querySelectorAll('.nt-qty-input').forEach(function (inp) {
      qty += parseInt(inp.value || '0', 10);
    });

    const total = unitPrice * Math.max(qty, 0);
    const symbol = (typeof ntConfig !== 'undefined' && ntConfig.currency) ? ntConfig.currency : '$';
    totalEl.textContent = symbol + total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  updateTotal();

  /* ── AJAX Add to cart / booking ── */
  const bookBtn = widget.querySelector('.nt-book-submit');
  if (bookBtn && typeof ntConfig !== 'undefined') {
    bookBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const form    = widget.querySelector('form');
      if (!form) return;

      bookBtn.disabled = true;
      bookBtn.textContent = ntConfig.i18n.loading;

      const fd = new FormData(form);
      fd.append('action', 'nt_add_booking');
      fd.append('nonce', ntConfig.nonce);

      fetch(ntConfig.ajaxUrl, { method: 'POST', body: fd })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success && data.data.redirect) {
            window.location.href = data.data.redirect;
          } else {
            alert(data.data.message || 'Something went wrong.');
            bookBtn.disabled = false;
            bookBtn.textContent = ntConfig.i18n.bookNow;
          }
        })
        .catch(function () {
          bookBtn.disabled = false;
          bookBtn.textContent = ntConfig.i18n.bookNow;
        });
    });
  }

  /* ── Sticky sidebar on scroll ── */
  const sidebar = document.querySelector('.nt-booking-sidebar');
  if (sidebar) {
    const offset = 96;
    function stickyCheck() {
      const rect = sidebar.parentElement.getBoundingClientRect();
      if (window.scrollY > 200 && rect.bottom > window.innerHeight) {
        sidebar.style.position = 'sticky';
        sidebar.style.top = offset + 'px';
      }
    }
    window.addEventListener('scroll', stickyCheck, { passive: true });
    stickyCheck();
  }
});
