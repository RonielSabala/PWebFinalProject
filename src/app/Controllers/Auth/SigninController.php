<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;
use App\Utils\GeneralUtils;


class SigninController
{
    public function handle(Template $template)
    {
        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $response = LoginController::logUser();
            if (is_string($response) && !empty($response)) {
                $template->apply();
                GeneralUtils::showAlert($response, showReturn: false);
            }

            exit;
        }

        $template->apply([
            'google_auth_url' => OAuthUtils::getGoogleUrl(),
        ]);
    }
}
