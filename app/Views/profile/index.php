<!-- app/Views/profile/index.php -->
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <span>My Profile</span>
    <span class="small text-muted">Changes require HR approval</span>
  </div>
  <div class="card-body">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal" role="tab">Personal</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#official" role="tab">Official</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#address" role="tab">Address</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#bank" role="tab">Bank</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ids" role="tab">IDs</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#family" role="tab">Family</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#docs" role="tab">Documents</button></li>
    </ul>

    <form id="profileForm" class="mt-3" novalidate>
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
      <!-- Personal tab -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="personal" role="tabpanel">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Gender</label>
              <select name="gender" class="form-select" required>
                <option value="">Select</option>
                <option<?= sel($p->gender,'Male')?>>Male</option>
                <option<?= sel($p->gender,'Female')?>>Female</option>
                <option<?= sel($p->gender,'Other')?>>Other</option>
              </select>
              <div class="invalid-feedback">Please select.</div>
            </div>
            <div class="col-md-4">
              <label class="form-label">DOB</label>
              <input type="date" name="dob" value="<?= e($p->dob) ?>" class="form-control" required>
              <div class="invalid-feedback">Required.</div>
            </div>
            <div class="col-md-4">
              <label class="form-label">Blood Group</label>
              <input type="text" name="blood_group" value="<?= e($p->blood_group) ?>" class="form-control" placeholder="A+, O-, ...">
            </div>
          </div>
        </div>

        <!-- Official (read-only) -->
        <div class="tab-pane fade" id="official" role="tabpanel">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Designation</label>
              <input type="text" class="form-control" value="<?= e($p->designation) ?>" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">Official Email</label>
              <input type="email" class="form-control" value="<?= e($p->official_email) ?>" readonly>
            </div>
            <div class="col-md-4">
              <label class="form-label">DOJ</label>
              <input type="date" class="form-control" value="<?= e($p->doj) ?>" readonly>
            </div>
          </div>
        </div>

        <!-- Other tabs omitted for brevity -->
      </div>

      <div class="d-flex justify-content-end gap-2 mt-3">
        <button type="button" class="btn btn-outline-secondary" id="btnDiscard">Discard</button>
        <button type="submit" class="btn btn-primary">Propose Changes</button>
      </div>
    </form>

    <div class="mt-4">
      <h6>Change history</h6>
      <table id="changesTable" class="table table-sm w-100">
        <thead><tr><th>Submitted</th><th>Status</th><th>Approver Level</th><th>Remarks</th></tr></thead>
      </table>
    </div>
  </div>
</div>

<script>
(() => {
  'use strict';
  const form = document.getElementById('profileForm');
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!form.checkValidity()) { form.classList.add('was-validated'); return; }
    const formData = new FormData(form);
    const res = await fetch('/api/profile/propose', { method:'POST', body: formData });
    const json = await res.json();
    toast(json.ok ? 'Submitted for approval' : 'Failed', json.ok ? 'success' : 'danger');
  });

  $('#changesTable').DataTable({
    ajax: '/api/profile/changes',
    columns: [
      { data: 'created_at' },
      { data: 'status' },
      { data: 'approver_level', render: (d,t,r)=> `${d}/${r.max_level}` },
      { data: 'remarks' }
    ],
    responsive: true
  });
})();
</script>
