<?php

namespace App\Utils\Entities;

use PDO;


class MunicipalityUtils extends GenericUtils
{
    private static $getByIdSql = "SELECT * FROM municipalities WHERE id = ?";

    private static $getAllSql = "SELECT * FROM municipalities ORDER BY municipality_name";

    private static $getAllByProvinceIdSql = "SELECT id, municipality_name FROM municipalities WHERE province_id = ?";

    private static $createSql = "INSERT INTO municipalities (municipality_name, province_id) VALUES (?, ?)";

    private static $updateSql = "UPDATE municipalities SET municipality_name = ?, province_id = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM municipalities WHERE id = ?";

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

    public static function getAllByProvinceId($provinceId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getAllByProvinceIdSql);
        $stmt->execute([$provinceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($municipalityName, $provinceId)
    {
        return self::executeSql(self::$createSql, [$municipalityName, $provinceId]);
    }

    public static function update($MunicipalityId, $municipalityName, $provinceId)
    {
        return self::executeSql(self::$updateSql, [$municipalityName, $provinceId, $MunicipalityId]);
    }

    public static function delete($id)
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
