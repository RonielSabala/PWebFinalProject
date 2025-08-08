<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class LabelUtils
{
    private static $getAllSQL = "SELECT * FROM labels";
    private static $getByIdSQL = "SELECT * FROM labels WHERE id = ?";
    private static $createSQL = "INSERT INTO labels (label_name) VALUES (?)";
    private static $updateSQL = "UPDATE labels SET label_name = ? WHERE id = ?";
    private static $deleteSQL = "DELETE FROM labels WHERE id = ?";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSQL);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($labelName)
    {
        return GeneralUtils::executeSql(self::$createSQL, [$labelName]);
    }

    public static function update($labelName, $id)
    {
        return GeneralUtils::executeSql(self::$updateSQL, [$labelName, $id]);
    }

    public static function delete($id)
    {
        return GeneralUtils::executeSql(self::$deleteSQL, [$id]);
    }
}
