<?php

namespace App\Utils\Entities;

use PDO;


class ProvinceUtils extends GenericUtils
{
    private static $getByIdSql = "SELECT * FROM provinces WHERE id = ?";

    private static $getAllSql = "SELECT * FROM provinces ORDER BY province_name";

    private static $createSql = "INSERT INTO provinces (province_name) VALUES (?)";

    private static $updateSql = "UPDATE provinces SET province_name = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM provinces WHERE id = ?";

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($provinceName)
    {
        return self::executeSql(self::$createSql, [$provinceName]);
    }

    public static function update($provinceId, $provinceName)
    {
        return self::executeSql(self::$updateSql, [$provinceName, $provinceId]);
    }

    public static function delete($id)
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
