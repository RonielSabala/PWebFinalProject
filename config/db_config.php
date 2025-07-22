<?php
$host = "127.0.0.1";
$user = "dummy";
$pass = "";
$db = "incidentes_db";

try {
    $pdo = new \PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass
    );
} catch (\PDOException $e) {
    die("Error de BD: " . $e->getMessage());
}
