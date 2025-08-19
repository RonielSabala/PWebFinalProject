<?php
const BASE_PATH = __DIR__ . '/../';
require_once BASE_PATH . 'vendor/autoload.php';
require_once BASE_PATH . 'config/db.php';
require_once BASE_PATH . 'config/google.php';
require_once BASE_PATH . 'config/microsoft.php';

use App\Controllers;
use App\Controllers\Auth as Auth;
use App\Controllers\Incidents as Incidents;
use App\Controllers\Reporters as Reporters;
use App\Controllers\Super\Validator as Validator;
use App\Controllers\Super\Admin as Admin;


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

// Rutas y controladores asociados
const DEFAULT_PAGE = 'home';
const DEFAULT_ROUTE = ['page' => DEFAULT_PAGE, 'controller' => Controllers\HomeController::class];
const ROUTES = [
    // Default views
    ''          => DEFAULT_ROUTE,
    'home.php'  => DEFAULT_ROUTE,
    'index.php' => DEFAULT_ROUTE,

    // Auth views
    'auth/login.php'           => ['controller' => Auth\LoginController::class],
    'auth/logout.php'          => ['controller' => Auth\LogoutController::class],
    'auth/signin.php'          => ['controller' => Auth\SigninController::class],
    'auth/forgot_password.php' => ['controller' => Auth\ForgotPasswordController::class],
    'auth/reset_password.php'  => ['controller' => Auth\ResetPasswordController::class],

    // Auth controllers
    'auth/GoogleController.php'            => ['controller' => Auth\GoogleController::class],
    'auth/MicrosoftController.php'         => ['controller' => Auth\MicrosoftController::class],
    'auth/MicrosoftCallbackController.php' => ['controller' => Auth\MicrosoftCallbackController::class],

    // Incidents views
    'incidents/map.php'        => ['page' => 'incidents', 'controller' => Incidents\IncidentsController::class],
    'incidents/list.php'       => ['page' => 'incidents', 'controller' => Incidents\IncidentsController::class],
    'incidents/incidence.php'  => ['page' => 'incidence', 'controller' => Incidents\IncidenceController::class],
    'incidents/correction.php' => ['page' => 'incidents', 'controller' => Incidents\CorrectionController::class],

    // Reporters views
    'reporters/home.php'   => ['page' => 'reports', 'controller' => Reporters\HomeController::class],
    'reporters/report.php' => ['page' => 'reports', 'controller' => Reporters\ReportController::class],

    // Admins views

    'super/admin/home.php'  => ['page' => 'admin', 'controller' => Admin\HomeController::class],

    // Users
    'super/admin/users.php' => ['page' => 'users', 'controller' => Admin\UserController::class],

    // Provinces
    'super/admin/provinces/home.php'   => ['page' => 'provinces', 'controller' => Admin\ProvinceController::class],
    'super/admin/provinces/create.php' => ['page' => 'provinces', 'controller' => Admin\ProvinceController::class],
    'super/admin/provinces/edit.php'   => ['page' => 'provinces', 'controller' => Admin\ProvinceController::class],
    'super/admin/provinces/delete.php' => ['page' => 'provinces', 'controller' => Admin\ProvinceController::class],

    // Municipalities
    'super/admin/municipalities/home.php'   => ['page' => 'municipalities', 'controller' => Admin\MunicipalityController::class],
    'super/admin/municipalities/create.php' => ['page' => 'municipalities', 'controller' => Admin\MunicipalityController::class],
    'super/admin/municipalities/edit.php'   => ['page' => 'municipalities', 'controller' => Admin\MunicipalityController::class],
    'super/admin/municipalities/delete.php' => ['page' => 'municipalities', 'controller' => Admin\MunicipalityController::class],

    // Neighborhoods
    'super/admin/neighborhoods/home.php'   => ['page' => 'neighborhoods', 'controller' => Admin\NeighborhoodController::class],
    'super/admin/neighborhoods/create.php' => ['page' => 'neighborhoods', 'controller' => Admin\NeighborhoodController::class],
    'super/admin/neighborhoods/edit.php'   => ['page' => 'neighborhoods', 'controller' => Admin\NeighborhoodController::class],
    'super/admin/neighborhoods/delete.php' => ['page' => 'neighborhoods', 'controller' => Admin\NeighborhoodController::class],

    // Labels
    'super/admin/labels/home.php'   => ['page' => 'labels', 'controller' => Admin\LabelController::class],
    'super/admin/labels/create.php' => ['page' => 'labels', 'controller' => Admin\LabelController::class],
    'super/admin/labels/edit.php'   => ['page' => 'labels', 'controller' => Admin\LabelController::class],
    'super/admin/labels/delete.php' => ['page' => 'labels', 'controller' => Admin\LabelController::class],

    // Validator views

    'super/validator/home.php' => ['page' => 'validator', 'controller' => Validator\HomeController::class],

    // Validate incidents
    'super/validator/incidence_validation.php' => ['page' => 'incidence_validation', 'controller' => Validator\IncidenceValidationController::class],
    'super/validator/approve_incidence.php'    => ['page' => 'incidence_validation', 'controller' => Validator\ApproveIncidenceController::class],
    'super/validator/reject_incidence.php'     => ['page' => 'incidence_validation', 'controller' => Validator\RejectIncidenceController::class],

    // Validate corrections
    'super/validator/correction_validation.php' => ['page' => 'correction_validation', 'controller' => Validator\CorrectionValidationController::class],
    'super/validator/approve_correction.php'    => ['page' => 'correction_validation', 'controller' => Validator\ApproveCorrectionController::class],
    'super/validator/reject_correction.php'     => ['page' => 'correction_validation', 'controller' => Validator\RejectCorrectionController::class],
];

// Manejar rutas
$router = new App\Core\Router();
$router->dispatch();
