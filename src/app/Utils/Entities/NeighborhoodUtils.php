<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class NeighborhoodUtils
{
    private static $getAllSQL = "SELECT * FROM neighborhoods ORDER BY neighborhood_name";
    private static $getByMunicipalityIdSQL = "SELECT id, neighborhood_name FROM neighborhoods WHERE municipality_id = ?";
    private static $getByIdSQL = "SELECT * FROM neighborhoods WHERE id = ?";
    private static $createSQL = "INSERT INTO neighborhoods (neighborhood_name, municipality_id) VALUES (?, ?)";
    private static $updateSQL = "UPDATE neighborhoods SET neighborhood_name = ?, municipality_id = ? WHERE id = ?";
    private static $deleteSQL = "DELETE FROM neighborhoods WHERE id = ?";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllByMunicipalityId($municipalityId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByMunicipalityIdSQL);
        $stmt->execute([$municipalityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSQL);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($neighborhoodName, $municipalityId)
    {
        return GeneralUtils::executeSql(self::$createSQL, [$neighborhoodName, $municipalityId]);
    }

    public static function update($id, $neighborhoodName, $municipalityId)
    {
        return GeneralUtils::executeSql(self::$updateSQL, [$neighborhoodName, $municipalityId, $id]);
    }

    public static function delete($id)
    {
        return GeneralUtils::executeSql(self::$deleteSQL, [$id]);
    }
}
