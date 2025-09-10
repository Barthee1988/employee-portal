<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Kernel.php';

use App\Kernel;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CsrfMiddleware;
use App\Middlewares\RbacMiddleware;

$kernel = new Kernel();
$kernel->use(new CsrfMiddleware());
$kernel->use(new AuthMiddleware());
$kernel->use(new RbacMiddleware());

$kernel->get('/', 'DashboardController@index');                // role-based
$kernel->get('/login', 'AuthController@loginForm');
$kernel->post('/login', 'AuthController@login');
$kernel->post('/logout', 'AuthController@logout');

$kernel->group('/api', function($router) {
  // Profile
  $router->get('/profile', 'ProfileController@show');
  $router->post('/profile/propose', 'ProfileController@proposeUpdate');
  $router->get('/profile/changes', 'ProfileController@changes');

  // Payroll
  $router->get('/payroll/slips', 'PayrollController@list');
  $router->get('/payroll/slips/download', 'PayrollController@download');
  $router->post('/payroll/certificates', 'PayrollController@requestCertificate');
  $router->get('/payroll/requests', 'PayrollController@requests'); // HR

  // Attendance
  $router->get('/attendance/month', 'AttendanceController@month');
  $router->get('/attendance/history', 'AttendanceController@history');

  // Leave
  $router->post('/leave', 'LeaveController@create');
  $router->get('/leave', 'LeaveController@list');
  $router->post('/leave/{id}/approve', 'LeaveController@approve');
  $router->post('/leave/{id}/reject', 'LeaveController@reject');

  // Loan
  $router->post('/loan', 'LoanController@create');
  $router->get('/loan', 'LoanController@list');
  $router->post('/loan/{id}/approve', 'LoanController@approve');
  $router->post('/loan/{id}/reject', 'LoanController@reject');

  // Feedback
  $router->post('/feedback', 'FeedbackController@create');
  $router->get('/feedback', 'FeedbackController@list');
  $router->post('/feedback/{id}/reply', 'FeedbackController@reply'); // HR

  // Uploads
  $router->post('/upload', 'UploadController@store'); // PDF/JPEG/PNG
});
$kernel->run();
?>