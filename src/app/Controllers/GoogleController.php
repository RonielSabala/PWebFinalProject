<?php

namespace App\Controllers;

use App\Core\Template;
use App\Utils\GenericUtils;
use Google\Service\Oauth2 as Google_Service_Oauth2;


class GoogleController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        if (!isset($_GET['code'])) {
            header("Location: login/login.php");
            exit;
        }

        // Validar token
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        if (isset($token['error'])) {
            GenericUtils::showAlert("Error al autenticar con Google.", "danger", false);
            exit;
        }

        // Obtener datos del usuario
        $access_token = $token['access_token'];
        $google_client->setAccessToken($access_token);
        $google_service = new Google_Service_Oauth2($google_client);
        $user_data = $google_service->userinfo->get();

        // Guardar sesión y redirigir al login
        $_SESSION['google_access_token'] = $access_token;
        $_SESSION['google_user'] = [
            'nombre' => $user_data['givenName'] . ' ' . $user_data['familyName'],
            'email' => $user_data['email']
        ];

        header("Location: login/login.php");
    }
}
