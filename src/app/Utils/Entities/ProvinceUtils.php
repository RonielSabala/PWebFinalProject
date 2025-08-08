<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class ProvinceUtils
{
    private static $getAllSQL = "SELECT * FROM provinces ORDER BY province_name";
    private static $getByIdSQL = "SELECT * FROM provinces WHERE id = ?";
    private static $createSQL = "INSERT INTO provinces (province_name) VALUES (?)";
    private static $updateSQL = "UPDATE provinces SET province_name = ? WHERE id = ?";
    private static $deleteSQL = "DELETE FROM provinces WHERE id = ?";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSQL);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($provinceName)
    {
        return GeneralUtils::executeSql(self::$createSQL, [$provinceName]);
    }

    public static function update($id, $provinceName)
    {
        return GeneralUtils::executeSql(self::$updateSQL, [$provinceName, $id]);
    }

    public static function delete($id)
    {
        return GeneralUtils::executeSql(self::$deleteSQL, [$id]);
    }
}
