<?php

namespace App\Core;

use App\Utils\GenericUtils;


class Router
{
    public function dispatch()
    {
        global $pdo;

        // Iniciar la sesión si no está activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener URI y nombre de la vista
        $view = '';
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $uri);
        if (count($parts) > 1) {
            $uri = implode('/', array_slice($parts, 0, -1));
            $view = end($parts);
        } else {
            $view = $uri;
            $uri = '';
        }

        // Obtener ruta
        if (isset(ROUTES[$view])) {
            $route = ROUTES[$view];
            $controller = new $route['controller']();
            if (isset($route['page'])) {
                define('CURRENT_PAGE', $route['page']);
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            GenericUtils::showAlert("Página no encontrada...", "danger");
            exit;
        }

        // Determinar nombre de la vista
        if ($view == '' || $view == 'index.php') {
            $viewPath = DEFAULT_PAGE;
        } else {
            $viewPath = preg_replace('/\.php$/', '', $view);
        }

        // Pre-configurar template
        if ($uri === '') {
            if ($viewPath === 'incident') {
                $viewPath = 'incidents/incident';
            }
        } else {
            $viewPath = $uri . '/' . $viewPath;
            Template::$partialsPath = $uri;
        }

        Template::$viewPath = $viewPath;

        // Iniciar vista
        $template = new Template();
        $controller->handle($template, $pdo);
    }
}
