<?php
const BASE_PATH = __DIR__ . '/../';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/config/db.php';
require_once BASE_PATH . '/config/google.php';
require_once BASE_PATH . '/config/microsoft.php';


// Rutas y controladores asociados
const DEFAULT_PAGE = 'incidence';
const DEFAULT_ROUTE = ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\Incidents\IncidenceController::class];
const ROUTES = [
    // Incidence views
    ''                                => DEFAULT_ROUTE,
    'index.php'                       => DEFAULT_ROUTE,
    'incidence.php'                   => DEFAULT_ROUTE,
    'map.php'                         => ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\Incidents\MapController::class],
    'list.php'                        => ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\Incidents\ListController::class],
    // Super routes
    'admin.php'                       => ['page' => 'admin', 'controller' => \App\Controllers\Super\AdminController::class],
    'validator.php'                   => ['page' => 'validator', 'controller' => \App\Controllers\Super\ValidatorController::class],
    // Auth routes
    'login.php'                       => ['controller' => \App\Controllers\Auth\LoginController::class],
    'logout.php'                      => ['controller' => \App\Controllers\Auth\LogoutController::class],
    'signin.php'                      => ['controller' => \App\Controllers\Auth\SigninController::class],
    'forgot_password.php'             => ['controller' => \App\Controllers\Auth\ForgotPasswordController::class],
    'reset_password.php'              => ['controller' => \App\Controllers\Auth\ResetPasswordController::class],
    'GoogleController.php'            => ['controller' => \App\Controllers\Auth\GoogleController::class],
    'MicrosoftController.php'         => ['controller' => \App\Controllers\Auth\MicrosoftController::class],
    'MicrosoftCallbackController.php' => ['controller' => \App\Controllers\Auth\MicrosoftCallbackController::class],
];

// Crear pdo
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass
    );
} catch (PDOException $e) {
    die("Error de BD: " . $e->getMessage());
}

// Manejar rutas
$router = new App\Core\Router();
$router->dispatch();
