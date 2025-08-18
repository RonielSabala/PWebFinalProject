<?php

namespace App\Controllers\Auth;

use App\Core\Template;
use App\Utils\OAuthUtils;


class MicrosoftController
{
    public function handle(Template $template)
    {
        $oauthClient = OAuthUtils::getMicrosoftClient();
        $authorizationUrl = $oauthClient->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $oauthClient->getState();
        header('Location: ' . $authorizationUrl);
        exit;
    }
}
