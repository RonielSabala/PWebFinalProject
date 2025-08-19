<?php

namespace App\Core;

use App\Utils\UriUtils;
use App\Utils\GeneralUtils;
use App\Utils\Entities\UserUtils;


class Router
{
    public function dispatch()
    {
        // Iniciar la sesión si no está activa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Iniciar el historial si no está activo
        if (!isset($_SESSION['uri_history'])) {
            $_SESSION['uri_history'] = [];
        }

        // Obtener URI y nombre de la vista
        $uri = UriUtils::get();
        [$route, $view] = UriUtils::split($uri);

        // Limpiar sesión y redirigir al login si no hay usuario
        if (!UserUtils::isUserInSession($route)) {
            session_unset();
            header('Location: /auth/login.php');
            exit;
        }

        // Obtener ruta
        $uri_route = ROUTES[$uri] ?? null;
        if ($uri_route) {
            $controller = new $uri_route['controller']();
            define('CURRENT_PAGE', $uri_route['page'] ?? '');
        }

        // Validar acceso a la vista
        $pageNotFound = $uri_route === null;
        if (!$pageNotFound && !str_contains($route, 'auth')) {
            $userRole = UserUtils::getRoleByUserId($_SESSION['user']['id']);
            $pageNotFound = match ($userRole) {
                'default'   => ($route !== '' && !str_contains($route, 'incidents')),
                'reporter'  => str_contains($route, 'super/'),
                'validator' => str_contains($route, 'reporters') || str_contains($route, 'super/admin'),
                default     => false,
            };
        }

        if ($pageNotFound) {
            http_response_code(404);
            GeneralUtils::showAlert('Página no encontrada...');
            exit;
        }

        // Determinar nombre de la vista
        if ($view === '' || ($route === '' && $view === 'index.php')) {
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
