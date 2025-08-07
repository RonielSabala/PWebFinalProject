<?php

namespace App\Utils\Entities;

use PDO;


class NeighborhoodUtils
{
    private static $getByMunicipalityIdSQL = "SELECT id, neighborhood_name FROM neighborhoods WHERE municipality_id = ?";

    public static function getAllByMunicipalityId($municipalityId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByMunicipalityIdSQL);
        $stmt->execute([$municipalityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
