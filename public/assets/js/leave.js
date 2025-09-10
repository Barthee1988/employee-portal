// public/assets/js/leave.js

(function () {
  'use strict';

  // Initialize leave list table
  window.initLeaveTable = function () {
    const tbl = $('#leaveTable').DataTable({
      ajax: '/api/leave',
      columns: [
        { data: 'type' },
        { data: 'start_date' },
        { data: 'end_date' },
        { data: 'half_day' },
        { data: 'status' },
        {
          data: 'id',
          orderable: false,
          render: (id, t, row) =>
            row.status === 'pending'
              ? `<button class="btn btn-sm btn-outline-primary" data-act="edit" data-id="${id}">Edit</button>`
              : ''
        }
      ],
      responsive: true,
      dom: 'Bfrtip',
      buttons: ['excel', 'pdf']
    });

    $('#leaveTable').on('click', 'button[data-act="edit"]', (e) => {
      const id = e.currentTarget.getAttribute('data-id');
      // Load leave by id and open modal (implement if needed)
      toast('Edit not implemented in this demo', 'warning');
    });

    return tbl;
  };

  // Hook up leave form
  window.initLeaveForm = function () {
    const form = document.getElementById('leaveForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(form);
      try {
        const res = await fetch('/api/leave', {
          method: 'POST',
          body: fd,
          headers: { 'X-CSRF-Token': csrfToken() }
        });
        const json = await res.json();
        if (json.ok) {
          toast('Leave request submitted', 'success');
          $('#leaveTable').DataTable().ajax.reload();
          form.reset();
        } else {
          toast(json.error || 'Submission failed', 'danger');
        }
      } catch (err) {
        toast('Network error submitting leave', 'danger');
      }
    });
  };
})();
