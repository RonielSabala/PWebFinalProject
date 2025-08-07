<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;


class SigninController
{
    public function handle(Template $template)
    {
        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = LoginController::log_user();
            if (!$success) {
                $template->apply();
            }

            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);
    }
}
