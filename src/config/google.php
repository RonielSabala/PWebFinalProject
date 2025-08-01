<?php
$google_client = new Google_Client();

// Configuración de google
$google_client->setClientId('44182864352-g12lc67bhb6plk8sqq50han7oqnjqrrc.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost:1111/GoogleController.php');
$google_client->addScope('email');
$google_client->addScope('profile');
