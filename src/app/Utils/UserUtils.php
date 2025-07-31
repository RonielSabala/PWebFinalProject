<?php

namespace App\Utils;

use PDO;


class UserUtils
{
    private static $getUserSQL = "SELECT u.id, u.nombre, u.email, u.telefono, u.password_hash, r.nombre AS rol
        FROM usuarios u
        JOIN roles_usuarios ru ON u.id = ru.usuarios_id
        JOIN roles r ON ru.roles_id = r.id
        WHERE u.email = ?";

    private static $userExistSQL = "SELECT 1 FROM usuarios WHERE email = ?";

    private static $createUserSQL = "INSERT INTO usuarios (nombre, email, telefono, password_hash) VALUES (?, ?, ?, ?)";

    private static $getRoleIdSQL = "SELECT id FROM roles WHERE nombre = ?";

    private static $createUserRoleSQL = "INSERT INTO roles_usuarios (roles_id, usuarios_id) VALUES (?, ?)";

    private static $updatePasswordSQL = "UPDATE usuarios SET password_hash = :pass WHERE email = :email";

    public static function exists(string $email)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$userExistSQL);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() ? true : false;
    }

    public static function get(string $email)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getUserSQL);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function create($nombre, $email, $telefono, $password)
    {
        global $pdo;

        // 1) Insertar usuario
        $stmt = $pdo->prepare(self::$createUserSQL);
        $stmt->execute([$nombre, $email, $telefono, password_hash($password, PASSWORD_DEFAULT)]);
        $usuario_id = $pdo->lastInsertId();

        // 2) Obtener el rol id
        $stmt = $pdo->prepare(self::$getRoleIdSQL);
        $stmt->execute(['default']);
        $rol_id = $stmt->fetchColumn();

        // 3) Insertar relación entre usuario y rol
        $stmt = $pdo->prepare(self::$createUserRoleSQL);
        $stmt->execute([$rol_id, $usuario_id]);
    }

    static public function updatePassword($email, $new_password)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$updatePasswordSQL);
        $stmt->bindParam(':email', $email,  PDO::PARAM_STR);
        $stmt->bindParam(':pass',  $new_password, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
