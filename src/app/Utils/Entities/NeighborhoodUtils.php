<?php

namespace App\Utils\Entities;

use PDO;


class NeighborhoodUtils extends GenericUtils
{
    private static $getByIdSql = "SELECT * FROM neighborhoods WHERE id = ?";

    private static $getAllSql = "SELECT * FROM neighborhoods ORDER BY neighborhood_name";

    private static $getAllByMunicipalityIdSql = "SELECT id, neighborhood_name FROM neighborhoods WHERE municipality_id = ?";

    private static $createSql = "INSERT INTO neighborhoods (neighborhood_name, municipality_id) VALUES (?, ?)";

    private static $updateSql = "UPDATE neighborhoods SET neighborhood_name = ?, municipality_id = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM neighborhoods WHERE id = ?";

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

    public static function getAllByMunicipalityId($municipalityId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getAllByMunicipalityIdSql);
        $stmt->execute([$municipalityId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($neighborhoodName, $municipalityId)
    {
        return self::executeSql(self::$createSql, [$neighborhoodName, $municipalityId]);
    }

    public static function update($id, $neighborhoodName, $municipalityId)
    {
        return self::executeSql(self::$updateSql, [$neighborhoodName, $municipalityId, $id]);
    }

    public static function delete($id)
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
