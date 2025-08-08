<?php

namespace App\Utils\Entities;


class MunicipalityUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM municipalities WHERE id = ?";

    private static $getAllSql = "SELECT * FROM municipalities ORDER BY municipality_name";

    private static $getAllByProvinceIdSql = "SELECT id, municipality_name FROM municipalities WHERE province_id = ?";

    private static $createSql = "INSERT INTO municipalities (municipality_name, province_id) VALUES (?, ?)";

    private static $updateSql = "UPDATE municipalities SET municipality_name = ?, province_id = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM municipalities WHERE id = ?";

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró el municipio.');
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function getAllByProvinceId($provinceId): array
    {

        return self::fetchAllSql(self::$getAllByProvinceIdSql, [$provinceId]);
    }

    public static function create($municipalityName, $provinceId): bool
    {
        return self::executeSql(self::$createSql, [$municipalityName, $provinceId]);
    }

    public static function update($MunicipalityId, $municipalityName, $provinceId): bool
    {
        return self::executeSql(self::$updateSql, [$municipalityName, $provinceId, $MunicipalityId]);
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
