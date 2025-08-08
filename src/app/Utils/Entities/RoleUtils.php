<?php

namespace App\Utils\Entities;


class RoleUtils extends GenericEntityUtils
{
    private static $getIdByNameSql = "SELECT id FROM roles WHERE role_name = ?";

    private static $assignUserRoleSql = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";

    private static $clearUserRolesSql = "DELETE FROM user_roles WHERE user_id = ?";

    public static function getIdByName($roleName)
    {
        $role = self::fetchSql(self::$getIdByNameSql, [$roleName]);
        return $role['id'] ?? null;
    }

    public static function assignUserRole($userId, $roleId): bool
    {
        return self::executeSql(self::$assignUserRoleSql, [$userId, $roleId]);
    }

    public static function clearUserRoles($userId): bool
    {
        return self::executeSql(self::$clearUserRolesSql, [$userId]);
    }
}
