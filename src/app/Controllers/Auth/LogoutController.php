<?php

namespace App\Controllers\Auth;

use App\Core\Template;


class LogoutController
{
    public function handle(Template $template)
    {
        global $google_client;

        // Cerrar sesión y redirigir al login
        $google_client->revokeToken();
        session_destroy();
        header('location: /auth/login.php');
    }
}
