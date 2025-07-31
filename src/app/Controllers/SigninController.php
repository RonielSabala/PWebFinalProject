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

        // Botones de registro
        $microsoft_button = '<a href="microsoft_login.php" class="btn btn-primary w-100 mb-2">Registrarse con Microsoft</a>';
        $google_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-danger w-100 mb-2">Registrarse con Google</a>';

        $template->apply([
            'google_button' => $google_button ?? "",
            'microsoft_button' => $microsoft_button,
        ]);
    }
}
