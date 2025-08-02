<?php

namespace App\Core;

use App\Utils\GenericUtils;


class Router
{
    public function dispatch()
    {
        // Iniciar la sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener URI y nombre de la vista
        $original_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $uri = $original_uri;
        $uri_parts = explode('/', $uri);
        if (count($uri_parts) > 1) {
            $uri = implode('/', array_slice($uri_parts, 0, -1));
            $view = end($uri_parts);
        } else {
            $view = $uri;
            $uri = '';
        }

        // Re-dirección al login si no hay un usuario en sesión
        if (!(isset($_SESSION['user']) || $uri == 'auth')) {
            header('Location: /auth/login.php');
            exit;
        }

        // Obtener ruta
        if (isset(ROUTES[$original_uri])) {
            $route = ROUTES[$original_uri];
            $controller = new $route['controller']();
            define('CURRENT_PAGE', $route['page'] ?? '');
        } else {
            GenericUtils::showAlert("Página no encontrada...", "danger");
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        // Determinar nombre de la vista
        if ($view === '' || $view === 'index.php') {
            $viewName = DEFAULT_PAGE;
        } else {
            $viewName = preg_replace('/\.php$/', '', $view);
        }

        // Configurar paths
        Template::$partialsPath = $uri;
        Template::$viewPath = $uri . '/' . $viewName;

        // Ejecutar controlador
        $controller->handle(new Template());
    }
}
