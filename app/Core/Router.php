<?php

namespace App\Core;

class Router
{
	/**
     * Stores all defined routes, grouped by HTTP method.
     *
     * @var array<string, array<string, array{action: string|array, name?: string}>>
     */
	private $routes = [];

	 /**
     * Stores the latest route URI and method for chaining (e.g., ->name()).
     */
    private ?string $lastUri = null;
    private ?string $lastMethod = null;

	public function get(string $uri, string|array $action): self
	{
		$this->routes['GET'][$uri] = [
			'action' => $action,
		];
		$this->lastUri = $uri;
		$this->lastMethod = 'GET';
		return $this;
	}

	public function post(string $uri, string|array $action): self
	{
		$this->routes['POST'][$uri] = [
			'action' => $action,
		];
		$this->lastUri = $uri;
		$this->lastMethod = 'POST';
		return $this;
	}

	public function put(string $uri, string|array $action): self
	{
		$this->routes['PUT'][$uri] = [
			'action' => $action,
		];
		$this->lastUri = $uri;
		$this->lastMethod = 'PUT';
		return $this;
	}

	public function delete(string $uri, string|array $action): self
	{
		$this->routes['DELETE'][$uri] = [
			'action' => $action,
		];
		$this->lastUri = $uri;
		$this->lastMethod = 'DELETE';
		return $this;
	}

	/**
     * Set the name of the last defined route (used for reverse routing, optional).
     */
    public function name(string $routeName): void
    {
        if ($this->lastMethod && $this->lastUri) {
            $this->routes[$this->lastMethod][$this->lastUri]['name'] = $routeName;
        }
    }

	/**
     * Match the current request URI and method to a defined route and execute it.
     *
     * @param string $uri The current request URI (e.g., from $_SERVER['REQUEST_URI'])
     */
	public function dispatch(string $uri): void
	{
		$method = $_SERVER['REQUEST_METHOD'];
		
		// Normalize the URI by removing query string and ensuring it starts with a slash
		$uri = rtrim(parse_url($uri, PHP_URL_PATH), '/') ?: '/';

		$route = $this->routes[$method][$uri] ?? null;
		
		if ($route === null) {
			http_response_code(404);
			echo "404 Not Found";
			return;
		}

		$action = $route['action'] ?? null;

		// Case 1: 'Controller@method' format
		if (is_string($action)) {
			[$controller, $methodName] = explode('@', $action);
			$controllerClass = "\\App\\Controllers\\$controller";
		}

		// Case 2: ['Controller::class', 'method'] format
		elseif (is_array($action) && is_string($action[0]) && is_string($action[1])) {
			[$controllerClass, $methodName] = $action;
		} else {
			echo "Invalid route action";
			return;
		}

		if (!class_exists($controllerClass)) {
			echo "Controller class {$controllerClass} not found";
			return;
		}

		$controllerInstance = new $controllerClass();
		
		if (!method_exists($controllerInstance, $methodName)) {
			echo "Method $methodName not found in controller $controllerClass";
			return;
		}

		// Dynamically call the method ($methodName) on the controller instance.
		// This allows routing to work even when the method name is determined at runtime.
		call_user_func([$controllerInstance, $methodName]);
	}
}