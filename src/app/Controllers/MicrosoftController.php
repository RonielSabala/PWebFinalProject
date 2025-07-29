<?php

namespace App\Controllers;

use App\Core\Template;


class MicrosoftController
{
    public function handle(Template $template, $pdo)
    {
        session_start();
        require_once 'vendor/autoload.php';
        $config = require 'config/microsoft.php';

        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $config['clientId'],
            'clientSecret'            => $config['clientSecret'],
            'redirectUri'             => $config['redirectUri'],
            'urlAuthorize'            => $config['authority'] . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => $config['authority'] . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
            'scopes'                  => $config['scopes']
        ]);

        if (!isset($_GET['code'])) {
            exit('Código de autorización no encontrado');
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

            header("Location: validar_registro.php");
            exit;
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            exit('Error al obtener token: ' . $e->getMessage());
        }
    }
}
