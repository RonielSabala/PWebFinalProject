<?php
// Credenciales de microsoft
$clientId = $_ENV['MICROSOFT_CLIENT_ID'];
$clientSecret = $_ENV['MICROSOFT_CLIENT_SECRET'];
$redirectUri = 'http://localhost:1111/auth/MicrosoftCallbackController.php';
$authority = 'https://login.microsoftonline.com/common';
$scopes = ['openid', 'profile', 'email', 'offline_access', 'User.Read'];
