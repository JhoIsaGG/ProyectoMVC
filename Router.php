<?php

class Router {
    private $routes = [];

    public function add(string $route, callable $handler): void {
        $this->routes[$route] = $handler;
    }

    public function dispatch(string $defaultRoute): void {
        // Obtener ruta (GET o default)
        $requestRoute = $_GET["action"] ?? $defaultRoute;

        $requestRoute = trim($requestRoute, "/");

        if ($requestRoute === '') {
            $requestRoute = $defaultRoute;
        }

        if (isset($this->routes[$requestRoute])) {
            call_user_func($this->routes[$requestRoute]);
            return;
        }

        // 404
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        echo "<p>No se encontró la ruta: <strong>$requestRoute</strong></p>";
    }
}

?>