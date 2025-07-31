<?php

namespace App\Controllers;

use App\Core\Template;
use App\Utils\OAuthUtils;


class MicrosoftController
{
    public function handle(Template $template, \PDO $pdo)
    {
        $oauthClient = OAuthUtils::getMicrosoftClient();
        $authorizationUrl = $oauthClient->getAuthorizationUrl();
        header('Location: ' . $authorizationUrl);
        exit;
    }
}
