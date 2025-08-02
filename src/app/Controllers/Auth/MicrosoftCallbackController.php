<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;
use App\Utils\GeneralUtils;


class MicrosoftCallbackController
{
    public function handle(Template $template)
    {
        $oauthClient = OAuthUtils::getMicrosoftClient();

        // Validar código
        if (!isset($_GET['code'])) {
            GeneralUtils::showAlert('Código de autorización no encontrado', "danger");
            exit;
        }

        // Validar estado
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            GeneralUtils::showAlert('El estado no es válido o ha expirado.', "danger");

            // Limpiar sesión
            session_unset();
            exit;
        }

        try {
            // Obtener los datos del usuario
            $accessToken = $oauthClient->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $request = $oauthClient->getAuthenticatedRequest(
                'GET',
                'https://graph.microsoft.com/v1.0/me',
                $accessToken
            );

            $response = $oauthClient->getResponse($request);
            $user_metadata = json_decode((string)$response->getBody(), true);

            // Guardar sesión y hacer login
            $_SESSION['user'] = [
                'username' => $user_metadata['displayName'],
                'email' => $user_metadata['userPrincipalName']
            ];

            LoginController::log_user();
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            GeneralUtils::showAlert('Error al obtener token: ' . $e->getMessage(), "danger");
        }
    }
}
