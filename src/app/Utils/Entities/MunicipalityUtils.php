<?php

namespace App\Utils\Entities;

use PDO;


class MunicipalityUtils
{
    private static $getByProvinceIdSQL = "SELECT id, municipality_name FROM municipalities WHERE province_id = ?";

    public static function getAllByProvinceId($province_id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByProvinceIdSQL);
        $stmt->execute([$province_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
