<?php
// Datos de conexión
$host = "127.0.0.1";
$user = "dummy";
$pass = "";
$db = "incidencias_db";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass
    );
} catch (\PDOException $e) {
    die("Error de BD: " . $e->getMessage());
}
