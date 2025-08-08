<?php

namespace App\Utils\Entities;


class ProvinceUtils extends GenericEntityUtils
{
    private static $getByIdSql = "SELECT * FROM provinces WHERE id = ?";

    private static $getAllSql = "SELECT * FROM provinces ORDER BY province_name";

    private static $createSql = "INSERT INTO provinces (province_name) VALUES (?)";

    private static $updateSql = "UPDATE provinces SET province_name = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM provinces WHERE id = ?";

    public static function getById($id)
    {
        return self::fetchSql(self::$getByIdSql, [$id]);
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function create($provinceName): bool
    {
        return self::executeSql(self::$createSql, [$provinceName]);
    }

    public static function update($provinceId, $provinceName): bool
    {
        return self::executeSql(self::$updateSql, [$provinceName, $provinceId]);
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
