<?php

namespace App\Utils\Entities;


class PhotoUtils extends GenericEntityUtils
{
    private static $createSql = "INSERT INTO photos (incidence_id, photo_url) VALUES (?, ?)";

    public static function create($fields): bool
    {
        return self::executeSql(self::$createSql, $fields);
    }
}
