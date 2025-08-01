<?php
require_once __DIR__ . '/../config/db.php';

// Leer los scripts SQL
$creationFile = __DIR__ . '/creation.sql';
$insertionsFile = __DIR__ . '/insertions.sql';
$creationSql = file_get_contents($creationFile);
$insertionsSql = file_get_contents($insertionsFile);

if (!$creationSql) {
    die("No se pudo leer el archivo para crear la base de datos.");
}

if (!$insertionsSql) {
    die("No se pudo leer el archivo para insertar los datos.");
}

try {
    // Crear las tablas
    $pdo = new PDO("mysql:host=$host", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $statements = array_filter(array_map('trim', explode(';', $creationSql)));
    foreach ($statements as $stmt) {
        if (!empty($stmt)) {
            $pdo->exec($stmt);
        }
    }

    // Insertar los datos

    if (!empty($db)) {
        $pdo->exec("USE `$db`;");
    }

    $insertStatements = array_filter(array_map('trim', explode(';', $insertionsSql)));
    foreach ($insertStatements as $stmt) {
        if (!empty($stmt)) {
            $pdo->exec($stmt);
        }
    }

    echo "✔️  Base de datos creada correctamente.\n";
} catch (PDOException $e) {
    die("Error de BD: " . $e->getMessage());
}
