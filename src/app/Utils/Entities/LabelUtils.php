<?php

namespace App\Utils\Entities;

use PDO;


class LabelUtils extends GenericEntityUtils
{
    private static $getByIdSql = "SELECT * FROM labels WHERE id = ?";

    private static $getAllSql = "SELECT * FROM labels";

    private static $createSql = "INSERT INTO labels (label_name) VALUES (?)";

    private static $updateSql = "UPDATE labels SET label_name = ? WHERE id = ?";

    private static $deleteSql = "DELETE FROM labels WHERE id = ?";

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($labelName)
    {
        return self::executeSql(self::$createSql, [$labelName]);
    }

    public static function update($labelId, $labelName)
    {
        return self::executeSql(self::$updateSql, [$labelName, $labelId]);
    }

    public static function delete($id)
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }
}
