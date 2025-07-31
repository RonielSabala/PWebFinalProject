<?php

namespace App\Core;


class Router
{
    public function dispatch()
    {
        global $pdo;

        // Obtener URI y nombre de la vista
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $parts = explode('/', $uri);
        if (count($parts) > 1) {
            $uri = implode('/', array_slice($parts, 0, -1));
            $view = end($parts);
        } else {
            $view = $uri;
            $uri = '';
        }

        // Rutas y controladores asociados
        $default_page = 'incident';
        $default_route = ['page' => $default_page,  'controller' => \App\Controllers\IncidentController::class];
        $routes = [
            ''                     => $default_route,
            'index.php'            => $default_route,
            'incident.php'         => $default_route,
            'list.php'             => ['page' => $default_page, 'controller' => \App\Controllers\ListController::class],
            'map.php'              => ['page' => $default_page, 'controller' => \App\Controllers\MapController::class],
            'validator.php'        => ['page' => 'validator',   'controller' => \App\Controllers\ValidatorController::class],
            'admin.php'            => ['page' => 'admin',       'controller' => \App\Controllers\AdminController::class],
            'login.php'            => ['page' => '',            'controller' => \App\Controllers\LoginController::class],
            'signin.php'           => ['page' => '',            'controller' => \App\Controllers\SigninController::class],
            'forgot_password.php'  => ['page' => '',            'controller' => \App\Controllers\ForgotPasswordController::class],
            'reset_password.php'   => ['page' => '',            'controller' => \App\Controllers\ResetPasswordController::class],
            'logout.php'           => ['page' => '',            'controller' => \App\Controllers\LogoutController::class],
            'GoogleController.php'    => ['page' => '',         'controller' => \App\Controllers\GoogleController::class],
            'MicrosoftController.php' => ['page' => '',         'controller' => \App\Controllers\MicrosoftController::class],
            'MicrosoftCallbackController.php' => ['page' => '', 'controller' => \App\Controllers\MicrosoftCallbackController::class],
        ];

        // Obtener ruta
        if (isset($routes[$view])) {
            $route = $routes[$view];
            $controller = new $route['controller']();
            define('CURRENT_PAGE', $route['page']);
        } else {
            header("HTTP/1.0 404 Not Found");
            exit("Página no encontrada...");
        }

        // Determinar nombre de la vista
        if ($view == '' || $view == 'index.php') {
            $viewPath = $default_page;
        } else {
            $viewPath = preg_replace('/\.php$/', '', $view);
        }

        // Manejar solicitud
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
