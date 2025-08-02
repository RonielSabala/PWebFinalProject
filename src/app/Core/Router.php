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
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
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

        // Re-dirección al incidente si no hay una vista definida
        if ($uri === '') {
            header("Location: /incidents/" . ($view === '' ? 'incidence.php' : $view));
            exit;
        }

        // Obtener ruta
        if (isset(ROUTES[$view])) {
            $route = ROUTES[$view];
            $controller = new $route['controller']();
            if (isset($route['page'])) {
                define('CURRENT_PAGE', $route['page']);
            }
        } else {
            GenericUtils::showAlert("Página no encontrada...", "danger");
            header("HTTP/1.0 404 Not Found");
            exit;
        }

        // Determinar nombre de la vista
        if ($view === '' || $view === 'index.php') {
            $viewPath = DEFAULT_PAGE;
        } else {
            $viewPath = preg_replace('/\.php$/', '', $view);
        }

        // Pre-configurar template
        Template::$partialsPath = $uri;
        Template::$viewPath = $uri . '/' . $viewPath;

        // Iniciar vista
        $template = new Template();
        $controller->handle($template);
    }
}
