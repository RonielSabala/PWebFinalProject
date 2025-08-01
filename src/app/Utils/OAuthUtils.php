<?php

namespace App\Utils;

use League\OAuth2\Client\Provider\GenericProvider;


class OAuthUtils
{
    public static function getGoogleUrl()
    {
        global $google_client;

        if (isset($_SESSION['google_access_token'])) {
            return "";
        }

        return $google_client->createAuthUrl();
    }

    public static function getMicrosoftClient()
    {
        global $clientId, $clientSecret, $redirectUri, $authority, $scopes;
        return new GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => $authority . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => $authority . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me',
            'scopes'                  => $scopes,
        ]);
    }
}
