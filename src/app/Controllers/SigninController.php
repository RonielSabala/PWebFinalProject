<?php

namespace App\Controllers;

use App\Core\Template;


class SigninController
{
    public function handle(Template $template, $pdo)
    {
        include('config/google.php');
        include('config/microsoft.php');

        $google_button = '';
        $microsoft_button = '';

        // Botón de Google (solo si no hay sesión)
        if (!isset($_SESSION['access_token'])) {
            $google_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-danger w-100 mb-2">Registrarse con Google</a>';
        }

        // Botón de Microsoft
        $microsoft_button = '<a href="microsoft_login.php" class="btn btn-primary w-100 mb-2">Registrarse con Microsoft</a>';

        $template->apply([
            'google_button' => $google_button,
            'microsoft_button' => $microsoft_button,
        ]);
    }
}
