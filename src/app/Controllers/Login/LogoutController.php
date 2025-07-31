<?php

namespace App\Controllers\Login;

use App\Core\Template;


class LogoutController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        // Cerrar sesión y redirigir al login
        $google_client->revokeToken();
        session_destroy();
        header('location:login/login.php');
    }
}
