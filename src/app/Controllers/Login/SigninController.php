<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\OAuthUtils;


class SigninController
{
    public function handle(Template $template)
    {
        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            LoginController::log_user();
            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);
    }
}
