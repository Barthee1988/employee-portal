<?php
// app/Controllers/DashboardController.php
namespace App\Controllers;

use App\Views\View;

class DashboardController {
  public function index(): string {
    $data = [
      'leave_available' => 12,
      'loan_status' => 'No active loans',
      'notifications' => ['Welcome to the portal!', 'Your profile is up to date.']
    ];
    return View::render('dashboard/index', ['data' => $data]);
  }
}
?>