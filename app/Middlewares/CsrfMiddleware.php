<?php
// app/Middlewares/CsrfMiddleware.php
namespace App\Middlewares;

class CsrfMiddleware {
	public function handle(): void {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$token = $_POST['csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
			$sessionToken = $_SESSION['csrf_token'] ?? '';
			if (!$token || $token !== $sessionToken) {
				http_response_code(403);
				exit('CSRF validation failed');
			}
		}
	}
}
?>