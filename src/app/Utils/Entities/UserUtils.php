<?php

namespace App\Utils\Entities;


class UserUtils extends GenericEntityUtils
{
    private static $userExistSql = "SELECT 1 FROM users WHERE email = ?";

    private static $getByEmailSql = "SELECT
        u.id,
        u.username,
        u.email,
        u.phone,
        u.password_hash,
        r.role_name
    FROM
        users u
    JOIN
        user_roles ur
    ON
        u.id = ur.user_id
    JOIN
        roles r
    ON
        ur.role_id = r.id
    WHERE
        u.email = ?
    ";

    private static $getAllSql = "SELECT
        u.id,
        u.username,
        u.email,
        u.phone,
        GROUP_CONCAT(r.role_name) as roles
    FROM
        users u
    LEFT JOIN
        user_roles ur ON u.id = ur.user_id
    LEFT JOIN
        roles r ON ur.role_id = r.id
    GROUP BY
        u.id
    ";

    private static $createUserSql = "INSERT INTO
    users (
        username,
        email,
        phone,
        password_hash
    )
    VALUES
        (?, ?, ?, ?)
    ";

    private static $updatePasswordSql = "UPDATE users SET password_hash = ? WHERE email = ?";

    public static function exists(string $userEmail): bool
    {
        return self::fetchSql(self::$userExistSql, [$userEmail]) ? true : false;
    }

    public static function getByEmail(string $userEmail)
    {
        return self::saveFetchSql(self::$getByEmailSql, [$userEmail], 'No se encontró el usuario.');
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function create($fields)
    {
        global $pdo;

        // Insertar usuario
        self::executeSql(self::$createUserSql, $fields);

        // Insertar relación Usuario-Rol
        $userId = $pdo->lastInsertId();
        $roleId = RoleUtils::getIdByName('default');
        RoleUtils::assignUserRole($userId, $roleId);
    }

    public static function updatePassword($userEmail, $newPassword): bool
    {
        return self::executeSql(self::$updatePasswordSql, [$newPassword, $userEmail]);
    }
}
