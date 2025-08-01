<?php
// Datos de conexión con la base de datos
$host = "127.0.0.1";
$user = "dummy";
$pass = "";
$db = "incidents_db";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass
    );
} catch (PDOException $e) {
    die("Error de BD: " . $e->getMessage());
}
