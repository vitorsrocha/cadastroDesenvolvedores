<?php

namespace App\Infrastructure\Route;

use Exception;

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
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

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
        echo json_encode('Rota não encontrada');
    }
}