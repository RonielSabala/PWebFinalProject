<?php

namespace App\Utils\Entities;


class LabelUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM labels WHERE id = ?";

    private static $getByNameSql = "SELECT * FROM labels WHERE label_name = ?";

    private static $getAllSql = "SELECT * FROM labels";

    private static $getAllByIncidenceIdSql = "SELECT
        l.label_name
    FROM
        labels l
    JOIN
        incidence_labels il
    ON
        il.label_id = l.id
    WHERE
        il.incidence_id = ?
    ORDER BY
        l.label_name
    ";

    private static $createSql = "INSERT INTO labels (label_name, icon_url) VALUES (?, ?)";

    private static $updateSql = "UPDATE labels SET label_name = ?, icon_url = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM labels WHERE id = ?";

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró la etiqueta.');
    }

    public static function getByName($labelName)
    {
        return self::saveFetchSql(self::$getByNameSql, [$labelName], 'No se encontró la etiqueta.');
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function getAllByIncidenceId($incidenceId): array
    {
        return self::fetchAllSql(self::$getAllByIncidenceIdSql, [$incidenceId]);
    }

    public static function create($labelName, $iconUrl): bool
    {
        return self::executeSql(self::$createSql, [$labelName, $iconUrl]);
    }

    public static function update($labelId, $labelName, $iconUrl): bool
    {
        return self::executeSql(self::$updateSql, [$labelName, $iconUrl, $labelId]);
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
