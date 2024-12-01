<?php

namespace App\Infrastructure\Route;

class Route
{
    private array $routes = [];

    public function addRoute($method, $route, $callback): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $route,
            'callback' => $callback
        ];
    }

    public function handleRequest(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = strtok($uri, '?');
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['route'] === $uri) {
                $params = $_GET;
                call_user_func_array($route['callback'], array_values($params));
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada'], JSON_PRETTY_PRINT);
    }
}