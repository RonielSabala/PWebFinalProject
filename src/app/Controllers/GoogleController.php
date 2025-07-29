<?php

namespace App\Controllers;

use App\Core\Template;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class GoogleController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        if (isset($_GET['code'])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (!isset($token['error'])) {
                $google_client->setAccessToken($token['access_token']);
                $_SESSION['access_token'] = $token['access_token'];

                $google_service = new Google_Service_Oauth2($google_client);
                $data = $google_service->userinfo->get();

                // Guardar datos relevantes en sesión
                $_SESSION['google_user'] = [
                    'email' => $data['email'],
                    'first_name' => $data['givenName'],
                    'last_name' => $data['familyName']
                ];

                // Redirigir a la lógica común de registro
                header("Location: login/login.php");
                exit;
            } else {
                echo "Error al autenticar con Google.";
            }
        } else {
            header("Location: login/login.php");
            exit;
        }
    }
}
