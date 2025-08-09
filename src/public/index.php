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
    // Auth routes
    'auth/login.php'                       => ['controller' => \App\Controllers\Auth\LoginController::class],
    'auth/logout.php'                      => ['controller' => \App\Controllers\Auth\LogoutController::class],
    'auth/signin.php'                      => ['controller' => \App\Controllers\Auth\SigninController::class],
    'auth/forgot_password.php'             => ['controller' => \App\Controllers\Auth\ForgotPasswordController::class],
    'auth/reset_password.php'              => ['controller' => \App\Controllers\Auth\ResetPasswordController::class],
    'auth/GoogleController.php'            => ['controller' => \App\Controllers\Auth\GoogleController::class],
    'auth/MicrosoftController.php'         => ['controller' => \App\Controllers\Auth\MicrosoftController::class],
    'auth/MicrosoftCallbackController.php' => ['controller' => \App\Controllers\Auth\MicrosoftCallbackController::class],
    // Incidence views
    'incidents/map.php'       => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\MapController::class],
    'incidents/list.php'      => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\ListController::class],
    'incidents/incidence.php' => ['page' => 'incidence', 'controller' => \App\Controllers\Incidents\IncidenceController::class],
    // Reporters views
    'reporters/home.php'           => ['controller' => \App\Controllers\Reporters\HomeController::class],
    'reporters/edit_incidence.php' => ['controller' => \App\Controllers\Reporters\EditIncidenceController::class],

    // Super routes
    'super/admin/home.php'     => ['page' => 'admin',     'controller' => \App\Controllers\Super\Admin\HomeController::class],
    'super/validator/home.php' => ['page' => 'validator', 'controller' => \App\Controllers\Super\Validator\HomeController::class],

    // super/admin/...

    // Usuarios
    'super/admin/users.php' => ['page' => 'users', 'controller' => \App\Controllers\Super\Admin\UserController::class],

    // Provincias
    'super/admin/provinces/home.php'   => ['page' => 'provinces', 'controller' => \App\Controllers\Super\Admin\ProvinceController::class],
    'super/admin/provinces/create.php' => ['page' => 'provinces', 'controller' => \App\Controllers\Super\Admin\ProvinceController::class],
    'super/admin/provinces/edit.php'   => ['page' => 'provinces', 'controller' => \App\Controllers\Super\Admin\ProvinceController::class],
    'super/admin/provinces/delete.php' => ['page' => 'provinces', 'controller' => \App\Controllers\Super\Admin\ProvinceController::class],

    // Municipios
    'super/admin/municipalities/home.php'   => ['page' => 'municipalities', 'controller' => \App\Controllers\Super\Admin\MunicipalityController::class],
    'super/admin/municipalities/create.php' => ['page' => 'municipalities', 'controller' => \App\Controllers\Super\Admin\MunicipalityController::class],
    'super/admin/municipalities/edit.php'   => ['page' => 'municipalities', 'controller' => \App\Controllers\Super\Admin\MunicipalityController::class],
    'super/admin/municipalities/delete.php'   => ['page' => 'municipalities', 'controller' => \App\Controllers\Super\Admin\MunicipalityController::class],

    // Barrios
    'super/admin/neighborhoods/home.php'   => ['page' => 'neighborhoods', 'controller' => \App\Controllers\Super\Admin\NeighborhoodController::class],
    'super/admin/neighborhoods/create.php' => ['page' => 'neighborhoods', 'controller' => \App\Controllers\Super\Admin\NeighborhoodController::class],
    'super/admin/neighborhoods/edit.php'   => ['page' => 'neighborhoods', 'controller' => \App\Controllers\Super\Admin\NeighborhoodController::class],

    // Etiquetas
    'super/admin/labels/home.php'   => ['page' => 'labels', 'controller' => \App\Controllers\Super\Admin\LabelController::class],
    'super/admin/labels/create.php' => ['page' => 'labels', 'controller' => \App\Controllers\Super\Admin\LabelController::class],
    'super/admin/labels/edit.php'   => ['page' => 'labels', 'controller' => \App\Controllers\Super\Admin\LabelController::class],
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
