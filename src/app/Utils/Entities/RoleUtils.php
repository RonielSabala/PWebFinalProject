<?php

namespace App\Utils\Entities;


class RoleUtils extends GenericUtils
{
    private static $getIdByNameSql = "SELECT id FROM roles WHERE role_name = ?";

    private static $assignUserRoleSql = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";

    private static $clearUserRolesSql = "DELETE FROM user_roles WHERE user_id = ?";

    public static function getIdByName($roleName)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getIdByNameSql);
        $stmt->execute([$roleName]);
        return $stmt->fetchColumn();
    }

    public static function assignUserRole($userId, $roleId)
    {
        return self::executeSql(self::$assignUserRoleSql, [$userId, $roleId]);
    }

    public static function clearUserRoles($userId)
    {
        return self::executeSql(self::$clearUserRolesSql, [$userId]);
    }
}
