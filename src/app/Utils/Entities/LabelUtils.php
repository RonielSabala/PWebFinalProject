<?php

namespace App\Utils\Entities;

use PDO;


class LabelUtils
{
    private static $getAllSQL = "SELECT * FROM labels";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
