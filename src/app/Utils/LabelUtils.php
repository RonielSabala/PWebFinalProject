<?php

namespace App\Utils;

use PDO;


class LabelUtils
{
    private static $getAllSQL = "SELECT * FROM labels";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(Self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
