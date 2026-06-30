<?php
declare(strict_types=1);
namespace App\Core;

final class Router
{
    private array $routes = [];
    public function get(string $path, array $handler, array $middleware = []): void { $this->routes['GET'][$path]=[$handler,$middleware]; }
    public function post(string $path, array $handler, array $middleware = []): void { $this->routes['POST'][$path]=[$handler,$middleware]; }
    public function dispatch(Container $container): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'; $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        [$handler,$middleware] = $this->routes[$method][$path] ?? $this->routes['GET']['/404'];
        foreach ($middleware as $class) { $container->get($class)->handle(); }
        [$controller,$action] = $handler; $instance = $container->get($controller); $instance->{$action}();
    }
}
