// public/assets/js/app.js

(function () {
  'use strict';

  // CSRF helper: looks for meta or hidden input
  window.csrfToken = function csrfToken() {
    const meta = document.querySelector('meta[name="csrf"]');
    if (meta) return meta.getAttribute('content');
    const hidden = document.querySelector('input[name="csrf"]');
    return hidden ? hidden.value : '';
  };

  // Toast helper (Bootstrap)
  window.toast = function (message, variant = 'primary') {
    let container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
      container.setAttribute('aria-live', 'polite');
      container.setAttribute('aria-atomic', 'true');
      document.body.appendChild(container);
    }
    const toastEl = document.createElement('div');
    toastEl.className = 'toast align-items-center text-bg-' + variant;
    toastEl.setAttribute('role', 'status');
    toastEl.setAttribute('aria-live', 'polite');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>`;
    container.appendChild(toastEl);
    const bsToast = new bootstrap.Toast(toastEl, { delay: 3500 });
    bsToast.show();
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
  };

  // Sidebar toggle
  const toggleBtn = document.getElementById('sidebarToggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      const sidebar = document.getElementById('sidebar');
      if (sidebar) {
        const bsCollapse = new bootstrap.Collapse(sidebar, { toggle: false });
        if (sidebar.classList.contains('show')) bsCollapse.hide();
        else bsCollapse.show();
      }
    });
  }

  // Global fetch wrapper adds CSRF and JSON headers
  window.apiFetch = async function (url, options = {}) {
    const defaults = {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      credentials: 'same-origin'
    };
    const method = (options.method || 'GET').toUpperCase();
    const headers = defaults.headers;
    if (method !== 'GET' && !(options.body instanceof FormData)) {
      headers['Content-Type'] = 'application/json';
      headers['X-CSRF-Token'] = csrfToken();
    }
    const merged = Object.assign({}, defaults, options, { headers });
    const res = await fetch(url, merged);
    if (!res.ok) {
      const text = await res.text();
      throw new Error(text || `Request failed: ${res.status}`);
    }
    const ct = res.headers.get('content-type') || '';
    return ct.includes('application/json') ? res.json() : res;
  };

  // Accessibility: focus outline only via keyboard
  function handleFirstTab(e) {
    if (e.key === 'Tab') {
      document.body.classList.add('user-is-tabbing');
      window.removeEventListener('keydown', handleFirstTab);
      window.addEventListener('mousedown', handleMouseDownOnce);
    }
  }
  function handleMouseDownOnce() {
    document.body.classList.remove('user-is-tabbing');
    window.removeEventListener('mousedown', handleMouseDownOnce);
    window.addEventListener('keydown', handleFirstTab);
  }
  window.addEventListener('keydown', handleFirstTab);
})();
