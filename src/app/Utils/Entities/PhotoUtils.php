<?php

namespace App\Utils\Entities;


class PhotoUtils extends GenericEntityUtils
{
    private static $createSql = "INSERT INTO photos (incidence_id, photo_url) VALUES (?, ?)";

    public static function create($fields): bool
    {
        return self::executeSql(self::$createSql, $fields);
    }

    public static function deleteByIncidenceId($incidenceId): bool
    {
        $sql = "DELETE FROM photos WHERE incidence_id = ?";
        return self::executeSql($sql, [$incidenceId]);
    }
}
