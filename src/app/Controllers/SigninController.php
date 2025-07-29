<?php

namespace App\Controllers;

use App\Core\Template;


class SigninController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            LoginController::validate_sesion($pdo);
            exit;
        }

        // Botón de Google si no hay sesión
        if (!isset($_SESSION['access_token'])) {
            $google_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-danger w-100 mb-2">Registrarse con Google</a>';
        }

        $microsoft_button = '<a href="microsoft_login.php" class="btn btn-primary w-100 mb-2">Registrarse con Microsoft</a>';
        $template->apply([
            'google_button' => $google_button ?? "",
            'microsoft_button' => $microsoft_button,
        ]);
    }
}
