<?php

namespace App\Utils\Entities;


class ProvinceUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM provinces WHERE id = ?";

    private static $getByNameSql = "SELECT * FROM provinces WHERE province_name = ?";

    private static $getAllSql = "SELECT * FROM provinces ORDER BY province_name";

    private static $createSql = "INSERT INTO provinces (province_name) VALUES (?)";

    private static $updateSql = "UPDATE provinces SET province_name = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM provinces WHERE id = ?";

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró la provincia.');
    }

    public static function getByName($province_name)
    {
        return self::saveFetchSql(self::$getByNameSql, [$province_name], 'No se encontró la provincia.');
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
