<?php

namespace App\Utils\Entities;

use PDO;


class UserUtils
{
    private static $getUserSQL = "SELECT u.id, u.username, u.email, u.phone, u.password_hash, r.role_name
        FROM users u
        JOIN user_roles ur ON u.id = ur.user_id
        JOIN roles r ON ur.role_id = r.id
        WHERE u.email = ?";

    private static $userExistSQL = "SELECT 1 FROM users WHERE email = ?";

    private static $createUserSQL = "INSERT INTO users (username, email, phone, password_hash) VALUES (?, ?, ?, ?)";

    private static $getRoleIdSQL = "SELECT id FROM roles WHERE role_name = ?";

    private static $createUserRoleSQL = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";

    private static $updatePasswordSQL = "UPDATE users SET password_hash = :pass WHERE email = :email";

    public static function exists(string $email)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$userExistSQL);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() ? true : false;
    }

    public static function get_by(string $email)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getUserSQL);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($fields)
    {
        global $pdo;

        // Insertar usuario
        $stmt = $pdo->prepare(self::$createUserSQL);
        $stmt->execute($fields);
        $user_id = $pdo->lastInsertId();

        // Obtener role_id
        $stmt = $pdo->prepare(self::$getRoleIdSQL);
        $stmt->execute(['default']);
        $role_id = $stmt->fetchColumn();

        // Insertar relación Usuario-Rol
        $stmt = $pdo->prepare(self::$createUserRoleSQL);
        $stmt->execute([$user_id, $role_id]);
    }

    public static function updatePassword($email, $new_password)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$updatePasswordSQL);
        $stmt->bindParam(':email', $email,  PDO::PARAM_STR);
        $stmt->bindParam(':pass',  $new_password, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
