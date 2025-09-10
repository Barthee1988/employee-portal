<?php
// app/Kernel.php
namespace App;

class Kernel {
	private array $routes = [];
	private array $middlewares = [];
	private string $prefix = '';

	public function boot(): void {
		$this->use(new \App\Middlewares\CsrfMiddleware());
		$this->use(new \App\Middlewares\AuthMiddleware());
		$this->use(new \App\Middlewares\RbacMiddleware());
	}

	public function use($middleware): void {
		$this->middlewares[] = $middleware;
	}

	public function get(string $path, string $handler): void {
		$this->routes['GET'][$this->prefix . $path] = $handler;
	}

	public function post(string $path, string $handler): void {
		$this->routes['POST'][$this->prefix . $path] = $handler;
	}

	public function group(string $prefix, callable $callback): void {
		$prev = $this->prefix;
		$this->prefix .= $prefix;
		$callback($this);
		$this->prefix = $prev;
	}

	public function run(): void {
		$method = $_SERVER['REQUEST_METHOD'];
		$uri = strtok($_SERVER['REQUEST_URI'], '?');
		$handler = $this->routes[$method][$uri] ?? null;

		if (!$handler) {
			http_response_code(404);
			echo "404 Not Found";
			return;
		}

		foreach ($this->middlewares as $mw) {
			if (method_exists($mw, 'handle')) {
				$mw->handle();
			}
		}

		[$class, $method] = explode('@', $handler);
		$class = "\\App\\Controllers\\$class";
		$instance = new $class();
		$params = $this->extractParams($uri);
		echo $instance->$method($params);
	}

	private function extractParams(string $uri): array {
		// Basic placeholder for route params (can be expanded)
		return [];
	}
}
?>