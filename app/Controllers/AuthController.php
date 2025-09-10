<?php
// app/Controllers/AuthController.php
namespace App\Controllers;

use App\Views\View;

class AuthController {
  public function loginForm(): string {
    return View::render('auth/login');
  }

  public function login(): void {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    // Validate and authenticate
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'employee';
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    header('Location: /');
  }

  public function logout(): void {
    session_destroy();
    header('Location: /login');
  }
}
