<?php
const BASE_PATH = __DIR__ . '/../';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/config/db.php';
require_once BASE_PATH . '/config/google.php';
require_once BASE_PATH . '/config/microsoft.php';


// Rutas y controladores asociados
const DEFAULT_PAGE = 'incident';
const DEFAULT_ROUTE = ['page' => DEFAULT_PAGE,  'controller' => \App\Controllers\Incidents\IncidentController::class];
const ROUTES = [
    ''                     => DEFAULT_ROUTE,
    'index.php'            => DEFAULT_ROUTE,
    'incident.php'         => DEFAULT_ROUTE,
    'list.php'             => ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\Incidents\ListController::class],
    'map.php'              => ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\Incidents\MapController::class],
    'validator.php'        => ['page' => 'validator',  'controller' => \App\Controllers\Super\ValidatorController::class],
    'admin.php'            => ['page' => 'admin',      'controller' => \App\Controllers\Super\AdminController::class],
    'login.php'            => ['controller' => \App\Controllers\Login\LoginController::class],
    'logout.php'           => ['controller' => \App\Controllers\Login\LogoutController::class],
    'signin.php'           => ['controller' => \App\Controllers\Login\SigninController::class],
    'forgot_password.php'  => ['controller' => \App\Controllers\Login\ForgotPasswordController::class],
    'reset_password.php'   => ['controller' => \App\Controllers\Login\ResetPasswordController::class],
    'GoogleController.php'    => ['controller' => \App\Controllers\Login\GoogleController::class],
    'MicrosoftController.php' => ['controller' => \App\Controllers\Login\MicrosoftController::class],
    'MicrosoftCallbackController.php' => ['controller' => \App\Controllers\Login\MicrosoftCallbackController::class],
];

$router = new App\Core\Router();
$router->dispatch();
