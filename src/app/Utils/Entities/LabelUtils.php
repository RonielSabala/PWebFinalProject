<?php

namespace App\Utils\Entities;


class LabelUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM labels WHERE id = ?";

    private static $getAllSql = "SELECT * FROM labels";

    private static $createSql = "INSERT INTO labels (label_name) VALUES (?)";

    private static $updateSql = "UPDATE labels SET label_name = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM labels WHERE id = ?";

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró la etiqueta.');
    }

    public static function getAll(): array
    {
        return self::fetchAllSql(self::$getAllSql);
    }

    public static function create($labelName): bool
    {
        return self::executeSql(self::$createSql, [$labelName]);
    }

    public static function update($labelId, $labelName): bool
    {
        return self::executeSql(self::$updateSql, [$labelName, $labelId]);
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
