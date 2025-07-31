<?php

namespace App\Controllers;

use App\Core\Template;


class LogoutController
{
    public function handle(Template $template, $pdo)
    {
        global $google_client;

        $google_client->revokeToken();
        session_destroy();
        header('location:login/login.php');
    }
}
