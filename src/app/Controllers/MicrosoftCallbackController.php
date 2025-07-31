<?php

namespace App\Controllers;

use App\Core\Template;
use League\OAuth2\Client\Provider\GenericProvider;

class MicrosoftCallbackController
{
    public function handle(Template $template, \PDO $pdo)
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        global $clientId, $clientSecret, $redirectUri, $authority, $scopes;
        $oauthClient = new GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => $authority . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => $authority . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
            'scopes'                  => $scopes,
        ]);

        if (!isset($_GET['code'])) {
            exit('Código de autorización no encontrado');
        }

        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('El estado no es válido o ha expirado.');
        }

        try {
            $accessToken = $oauthClient->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $request = $oauthClient->getAuthenticatedRequest(
                'GET',
                'https://graph.microsoft.com/v1.0/me',
                $accessToken
            );

            $response = $oauthClient->getResponse($request);
            $user = json_decode((string)$response->getBody(), true);

            // Guardar en sesión para usar en validar_registro
            $_SESSION['microsoft_user'] = [
                'name' => $user['displayName'],
                'email' => $user['userPrincipalName']

            ];

            header("Location: login/login.php");
            exit;
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            exit('Error al obtener token: ' . $e->getMessage());
        }
    }
}
