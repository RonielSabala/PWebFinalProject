<?php

namespace App\Core;


class Router
{
    public function dispatch()
    {
        global $pdo;

        // Obtener URI
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // Rutas y controladores asociados
        $default = ['page' => 'incident',  'controller' => \App\Controllers\IncidentController::class];
        $routes = [
            ''           => $default,
            'index.php'  => $default,
            'incident.php'   => $default,
        ];

        // Obtener ruta
        if (isset($routes[$uri])) {
            $page = $routes[$uri]['page'];
            $controller = new $routes[$uri]['controller']();
        } else {
            header("HTTP/1.0 404 Not Found");
            exit("Página no encontrada...");
        }

        // Manejar solicitud
        define('CURRENT_PAGE', $page);
        $template = new Template();
        $controller->handle($template, $pdo);
    }
}
