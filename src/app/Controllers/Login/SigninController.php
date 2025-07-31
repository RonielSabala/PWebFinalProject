<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\OAuthUtils;


class SigninController
{
    public function handle(Template $template, $pdo)
    {
        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            LoginController::log_user($pdo);
            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);
    }
}
