<?php

namespace App\Utils\Entities;


class PhotoUtils
{
    private static $createSQL = "INSERT INTO photos (incidence_id, photo_url) VALUES (?, ?)";

    public static function create($fields)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$createSQL);
        $stmt->execute($fields);
    }
}
