<?php

namespace App\Core;

use App\Utils\GeneralUtils;


class Router
{
    public function dispatch()
    {
        // Iniciar la sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Obtener URI y nombre de la vista
        $uri = GeneralUtils::getURI();
        [$route, $view] = GeneralUtils::splitURI($uri);

        // Re-dirección al login si no hay un usuario en sesión
        if (!(isset($_SESSION['user']) || $route == 'auth')) {
            header('Location: /auth/login.php');
            exit;
        }

        // Obtener ruta
        $uri_route = ROUTES[$uri] ?? null;
        if ($uri_route) {
            $controller = new $uri_route['controller']();
            define('CURRENT_PAGE', $uri_route['page'] ?? '');
        } else {
            GeneralUtils::showAlert("Página no encontrada...", "danger");
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
        Template::$partialsPath = $route;
        Template::$viewPath = $route . '/' . $viewName;

        // Ejecutar controlador
        $controller->handle(new Template());
    }
}
