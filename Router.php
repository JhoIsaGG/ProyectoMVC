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

        $publicRoutes = ['index', 'login', 'usuario_login'];

        if (!in_array($requestRoute, $publicRoutes) && empty($_SESSION['usuario'])) {
            header("Location: index.php?action=index");
            exit;
        }

        // Si el usuario ya está logueado, no debe poder entrar al index ni al login
        if (in_array($requestRoute, ['index', 'login', 'usuario_login']) && !empty($_SESSION['usuario'])) {
            header("Location: index.php?action=home");
            exit;
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