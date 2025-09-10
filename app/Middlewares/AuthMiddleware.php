<?php
// app/Middlewares/AuthMiddleware.php
namespace App\Middlewares;

class AuthMiddleware {
	public function handle(): void {
		session_start();
		if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/login') {
			header('Location: /login');
			exit;
		}
	}
}
?>