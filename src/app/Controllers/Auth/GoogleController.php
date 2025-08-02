<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\GeneralUtils;
use Google\Service\Oauth2 as Google_Service_Oauth2;


class GoogleController
{
    public function handle(Template $template)
    {
        global $google_client;

        // Validar código
        if (!isset($_GET['code'])) {
            GeneralUtils::showAlert('Código de autorización no encontrado', "danger");
            exit;
        }

        // Validar token
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            GeneralUtils::showAlert("Error al autenticar con Google.", "danger", showReturn: false);
            exit;
        }

        // Obtener los datos del usuario
        $access_token = $token['access_token'];
        $google_client->setAccessToken($access_token);
        $google_service = new Google_Service_Oauth2($google_client);
        $user_metadata = $google_service->userinfo->get();

        // Guardar sesión y hacer login
        $_SESSION['google_access_token'] = $access_token;
        $_SESSION['user'] = [
            'username' => $user_metadata['givenName'] . ' ' . $user_metadata['familyName'],
            'email' => $user_metadata['email']
        ];

        LoginController::log_user();
    }
}
