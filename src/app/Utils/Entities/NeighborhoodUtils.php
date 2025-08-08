<?php

namespace App\Utils\Entities;


class NeighborhoodUtils extends GenericEntityUtils
{
    private static $getByIdSql = "SELECT * FROM neighborhoods WHERE id = ?";

    private static $getAllSql = "SELECT * FROM neighborhoods ORDER BY neighborhood_name";

    private static $getAllByMunicipalityIdSql = "SELECT id, neighborhood_name FROM neighborhoods WHERE municipality_id = ?";

    private static $createSql = "INSERT INTO neighborhoods (neighborhood_name, municipality_id) VALUES (?, ?)";

    private static $updateSql = "UPDATE neighborhoods SET neighborhood_name = ?, municipality_id = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM neighborhoods WHERE id = ?";

    public static function getById($id)
    {
        return self::fetchSql(self::$getByIdSql, [$id]);
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function getAllByMunicipalityId($municipalityId): array
    {
        return self::fetchAllSql(self::$getAllByMunicipalityIdSql, [$municipalityId]);
    }

    public static function create($neighborhoodName, $municipalityId): bool
    {
        return self::executeSql(self::$createSql, [$neighborhoodName, $municipalityId]);
    }

    public static function update($id, $neighborhoodName, $municipalityId): bool
    {
        return self::executeSql(self::$updateSql, [$neighborhoodName, $municipalityId, $id]);
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
