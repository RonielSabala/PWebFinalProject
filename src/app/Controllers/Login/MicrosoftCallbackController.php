<?php

namespace App\Controllers\Login;

use App\Core\Template;
use App\Utils\OAuthUtils;
use App\Utils\GenericUtils;


class MicrosoftCallbackController
{
    public function handle(Template $template)
    {
        $oauthClient = OAuthUtils::getMicrosoftClient();

        // Validar código
        if (!isset($_GET['code'])) {
            GenericUtils::showAlert('Código de autorización no encontrado', "danger");
            exit;
        }

        // Validar estado
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            GenericUtils::showAlert('El estado no es válido o ha expirado.', "danger");
            exit;
        }

        try {
            // Obtener datos del usuario

            $accessToken = $oauthClient->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $request = $oauthClient->getAuthenticatedRequest(
                'GET',
                'https://graph.microsoft.com/v1.0/me',
                $accessToken
            );

            $response = $oauthClient->getResponse($request);
            $user_data = json_decode((string)$response->getBody(), true);

            // Guardar sesión y redirigir al login
            $_SESSION['microsoft_user'] = [
                'nombre' => $user_data['displayName'],
                'email' => $user_data['userPrincipalName']
            ];

            header("Location: login/login.php");
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            GenericUtils::showAlert('Error al obtener token: ' . $e->getMessage(), "danger");
        }
    }
}
