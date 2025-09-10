<?php
// public/index.php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', getenv('APP_ENV') === 'local' ? '1' : '0');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Kernel.php';

use App\Kernel;

// Bootstrap app kernel and route
$kernel = new Kernel();

// Register global middlewares (defined later in app/)
$kernel->boot();

// Web routes
$kernel->get('/', 'DashboardController@index');
$kernel->get('/login', 'AuthController@loginForm');
$kernel->post('/login', 'AuthController@login');
$kernel->post('/logout', 'AuthController@logout');

// App pages (SSR views)
$kernel->get('/profile', 'ProfileController@index');
$kernel->get('/attendance', 'AttendanceController@index');
$kernel->get('/payroll', 'PayrollController@index');
$kernel->get('/leave', 'LeaveController@index');
$kernel->get('/loan', 'LoanController@index');
$kernel->get('/feedback', 'FeedbackController@index');
$kernel->get('/hr/approvals', 'Hr\\ApprovalsController@index');
$kernel->get('/hr/reports', 'Hr\\ReportsController@index');
$kernel->get('/hr/bulk-upload', 'Hr\\BulkUploadController@index');

// API routes
$kernel->group('/api', function ($r) {
  // Profile
  $r->get('/profile', 'ProfileController@show');
  $r->post('/profile/propose', 'ProfileController@proposeUpdate');
  $r->get('/profile/changes', 'ProfileController@changes');

  // Payroll
  $r->get('/payroll/slips', 'PayrollController@list');
  $r->get('/payroll/slips/download', 'PayrollController@download');
  $r->post('/payroll/certificates', 'PayrollController@requestCertificate');
  $r->get('/payroll/requests', 'PayrollController@requests');

  // Attendance
  $r->get('/attendance/month', 'AttendanceController@month');
  $r->get('/attendance/history', 'AttendanceController@history');

  // Leave
  $r->get('/leave', 'LeaveController@list');
  $r->post('/leave', 'LeaveController@create');
  $r->post('/leave/{id}/approve', 'LeaveController@approve');
  $r->post('/leave/{id}/reject', 'LeaveController@reject');

  // Loan
  $r->get('/loan', 'LoanController@list');
  $r->post('/loan', 'LoanController@create');
  $r->post('/loan/{id}/approve', 'LoanController@approve');
  $r->post('/loan/{id}/reject', 'LoanController@reject');

  // Feedback
  $r->get('/feedback', 'FeedbackController@list');
  $r->post('/feedback', 'FeedbackController@create');
  $r->post('/feedback/{id}/reply', 'FeedbackController@reply');

  // Upload
  $r->post('/upload', 'UploadController@store');

  // HR approvals listing (DataTables server-side)
  $r->get('/hr/approvals', 'Hr\\ApprovalsController@list');
});

$kernel->run();
?>