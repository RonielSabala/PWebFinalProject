<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Datos de conexión con la base de datos
$host = $_ENV['HOST'];
$user = $_ENV['USER'];
$pass = $_ENV['PASS'];
$db = "incidents_db";
