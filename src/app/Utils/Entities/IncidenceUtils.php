<?php

namespace App\Utils\Entities;

use PDO;


class IncidenceUtils
{
    private static $getAllSQL = "SELECT * FROM incidents";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(Self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
