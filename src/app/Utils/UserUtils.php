<?php

namespace App\Utils;


class UserUtils
{
    public static function exists(string $email)
    {
        global $pdo;

        $sql = "SELECT 1 FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() ? true : false;
    }

    public static function get(string $email)
    {
        global $pdo;

        $sql = "SELECT u.id, u.nombre, u.email, u.telefono, u.password_hash, r.nombre AS rol
        FROM usuarios u
        JOIN roles_usuarios ru ON u.id = ru.usuarios_id
        JOIN roles r ON ru.roles_id = r.id
        WHERE u.email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    static public function create($nombre, $email, $telefono, $password)
    {
        global $pdo;

        // 1) Insertar usuario
        $sql = "INSERT INTO usuarios (nombre, email, telefono, password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nombre, $email, $telefono, password_hash($password, PASSWORD_DEFAULT)]);
        $usuario_id = $pdo->lastInsertId();

        // 2) Obtener el rol id
        $sql = "SELECT id FROM roles WHERE nombre = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['default']);
        $rol_id = $stmt->fetchColumn();

        // 3) Insertar relación entre usuario y rol
        $sql = "INSERT INTO roles_usuarios (roles_id, usuarios_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$rol_id, $usuario_id]);
    }
}
