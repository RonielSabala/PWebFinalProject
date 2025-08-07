<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Configuración de google
$google_client = new Google_Client();
$google_client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$google_client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$google_client->setRedirectUri('http://localhost:1111/auth/GoogleController.php');
$google_client->addScope('email');
$google_client->addScope('profile');
