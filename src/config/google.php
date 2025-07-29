<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

//Include Google Client Library for PHP autoload file
require_once __DIR__ . '/../vendor/autoload.php';

// Instancia del cliente de Google
$google_client = new Google_Client();

// Autenticación
$google_client->setClientId('44182864352-g12lc67bhb6plk8sqq50han7oqnjqrrc.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost:1111/GoogleController.php');
// ESTA es la redirección que se usa después del login

// Permisos para obtener datos
$google_client->addScope('email');
$google_client->addScope('profile');
