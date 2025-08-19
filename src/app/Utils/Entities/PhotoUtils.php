<?php

namespace App\Utils\Entities;


class PhotoUtils extends GenericEntityUtils
{
    private static $createSql = "INSERT INTO photos (incidence_id, photo_url) VALUES (?, ?)";

    private static $deleteByIncidenceIdSql = "DELETE FROM photos WHERE incidence_id = ?";

    public static function create($fields): bool
    {
        return self::executeSql(self::$createSql, $fields);
    }

    public static function deleteByIncidenceId($incidenceId): bool
    {
        return self::executeSql(self::$deleteByIncidenceIdSql, [$incidenceId]);
    }
}
