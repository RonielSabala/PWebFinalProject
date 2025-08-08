<?php

namespace App\Utils\Entities;

use App\Utils\GeneralUtils;

class PhotoUtils
{
    private static $createSQL = "INSERT INTO photos (incidence_id, photo_url) VALUES (?, ?)";

    public static function create($fields)
    {
        return GeneralUtils::executeSql(self::$createSQL, $fields);
    }
}
