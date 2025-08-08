<?php
const BASE_PATH = __DIR__ . '/../';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/config/db.php';
require_once BASE_PATH . '/config/google.php';
require_once BASE_PATH . '/config/microsoft.php';


// Rutas y controladores asociados
const DEFAULT_PAGE = 'home';
const DEFAULT_ROUTE = ['page' => DEFAULT_PAGE, 'controller' => \App\Controllers\HomeController::class];
const ROUTES = [
    ''          => DEFAULT_ROUTE,
    'home.php'  => DEFAULT_ROUTE,
    'index.php' => DEFAULT_ROUTE,
    // Incidence views
    'incidents/map.php'       => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\MapController::class],
    'incidents/list.php'      => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\ListController::class],
    'incidents/incidence.php' => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\IncidenceController::class],
    // Reporters views
    'reporters/home.php'           => ['controller' => \App\Controllers\Reporters\HomeController::class],
    'reporters/edit_incidence.php' => ['controller' => \App\Controllers\Reporters\EditIncidenceController::class],
    // Super routes
    'super/admin.php'     => ['page' => 'admin',     'controller' => \App\Controllers\Super\AdminController::class],
    'super/validator.php' => ['page' => 'validator', 'controller' => \App\Controllers\Super\ValidatorController::class],
    // Auth routes
    'auth/login.php'                       => ['controller' => \App\Controllers\Auth\LoginController::class],
    'auth/logout.php'                      => ['controller' => \App\Controllers\Auth\LogoutController::class],
    'auth/signin.php'                      => ['controller' => \App\Controllers\Auth\SigninController::class],
    'auth/forgot_password.php'             => ['controller' => \App\Controllers\Auth\ForgotPasswordController::class],
    'auth/reset_password.php'              => ['controller' => \App\Controllers\Auth\ResetPasswordController::class],
    'auth/GoogleController.php'            => ['controller' => \App\Controllers\Auth\GoogleController::class],
    'auth/MicrosoftController.php'         => ['controller' => \App\Controllers\Auth\MicrosoftController::class],
    'auth/MicrosoftCallbackController.php' => ['controller' => \App\Controllers\Auth\MicrosoftCallbackController::class],

    // Admin CRUDs

    // Provincias
    'super/admin_entities/provinces/index.php'  => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/provinces/create.php' => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/provinces/edit.php'   => ['controller' => \App\Controllers\Super\AdminEntityController::class],

    // Municipios
    'super/admin_entities/municipalities/index.php'  => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/municipalities/create.php' => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/municipalities/edit.php'   => ['controller' => \App\Controllers\Super\AdminEntityController::class],

    // Barrios
    'super/admin_entities/neighborhoods/index.php'  => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/neighborhoods/create.php' => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/neighborhoods/edit.php'   => ['controller' => \App\Controllers\Super\AdminEntityController::class],

    // Etiquetas
    'super/admin_entities/labels/index.php'  => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/labels/create.php' => ['controller' => \App\Controllers\Super\AdminEntityController::class],
    'super/admin_entities/labels/edit.php'   => ['controller' => \App\Controllers\Super\AdminEntityController::class],
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
