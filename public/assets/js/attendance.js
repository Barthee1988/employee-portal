// public/assets/js/attendance.js
function colorForInTime(inTime) {
  if (!inTime) return 'secondary';
  const [h,m] = inTime.split(':').map(Number);
  const minutes = h*60 + m;
  if (minutes <= 9*60+15) return 'success';
  if (minutes <= 9*60+30) return 'warning';
  if (minutes <= 10*60) return 'orange';
  return 'danger';
}


// public/assets/js/attendance.js

(function () {
  'use strict';

  // Return a semantic badge class based on in_time
  window.inTimeBadge = function (inTime) {
    if (!inTime) return 'badge-in-time-ontime';
    const [h, m] = inTime.split(':').map(Number);
    const minutes = h * 60 + m;
    if (minutes <= 9 * 60 + 15) return 'badge-in-time-ontime'; // <= 9:15
    if (minutes <= 9 * 60 + 30) return 'badge-in-time-warn';   // 9:15–9:30
    if (minutes <= 10 * 60) return 'badge-in-time-late';       // 9:30–10:00
    return 'badge-in-time-red';                                 // > 10:00
  };

  // Example: render monthly grid into #attendanceGrid (to be used in view)
  window.renderAttendanceMonth = function (containerId, data) {
    const el = document.getElementById(containerId);
    if (!el) return;
    el.innerHTML = '';
    const grid = document.createElement('div');
    grid.className = 'row row-cols-2 row-cols-sm-4 row-cols-md-7 g-2';
    data.forEach(d => {
      const col = document.createElement('div');
      const badge = inTimeBadge(d.in_time);
      const typeLabel = d.type || 'P';
      col.innerHTML = `
        <div class="card h-100" aria-label="Day ${d.day} ${typeLabel}">
          <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
              <span class="small text-muted">${d.day.slice(-2)}</span>
              <span class="badge ${badge}">${d.in_time || '--'}</span>
            </div>
            <div class="small mt-1">${typeLabel}</div>
          </div>
        </div>`;
      grid.appendChild(col);
    });
    el.appendChild(grid);
  };
})();
