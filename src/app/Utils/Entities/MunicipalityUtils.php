<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class MunicipalityUtils
{
    private static $getAllSQL = "SELECT * FROM municipalities ORDER BY municipality_name";
    private static $getByProvinceIdSQL = "SELECT id, municipality_name FROM municipalities WHERE province_id = ?";
    private static $getByIdSQL = "SELECT * FROM municipalities WHERE id = ?";
    private static $createSQL = "INSERT INTO municipalities (municipality_name, province_id) VALUES (?, ?)";
    private static $updateSQL = "UPDATE municipalities SET municipality_name = ?, province_id = ? WHERE id = ?";
    private static $deleteSQL = "DELETE FROM municipalities WHERE id = ?";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllByProvinceId($province_id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByProvinceIdSQL);
        $stmt->execute([$province_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSQL);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($municipalityName, $provinceId)
    {
        GeneralUtils::executeSql(self::$createSQL, [$municipalityName, $provinceId]);
    }

    public static function update($id, $municipalityName, $provinceId)
    {
        GeneralUtils::executeSql(self::$updateSQL, [$municipalityName, $provinceId, $id]);
    }

    public static function delete($id)
    {
        GeneralUtils::executeSql(self::$deleteSQL, [$id]);
    }
}
