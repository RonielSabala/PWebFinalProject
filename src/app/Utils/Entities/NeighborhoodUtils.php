<?php

namespace App\Utils\Entities;

use PDO;


class NeighborhoodUtils
{
    private static $getByMunicipalityIdSQL = "SELECT id, neighborhood_name FROM neighborhoods WHERE municipality_id = ?";

    public static function getAllByMunicipalityId($municipality_id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByMunicipalityIdSQL);
        $stmt->execute([$municipality_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
