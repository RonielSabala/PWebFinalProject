<?php

namespace App\Utils;

use PDO;


class ProvinceUtils
{
    private static $getAllSQL = "SELECT * FROM provinces ORDER BY province_name";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(Self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
