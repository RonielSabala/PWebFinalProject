<?php

namespace App\Controllers;

use App\Core\Template;
use League\OAuth2\Client\Provider\GenericProvider;


class MicrosoftController
{
    public function handle(Template $template, \PDO $pdo)
    {
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

        $authorizationUrl = $oauthClient->getAuthorizationUrl();
        header('Location: ' . $authorizationUrl);
        exit;
    }
}
