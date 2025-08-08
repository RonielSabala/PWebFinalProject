<?php

namespace App\Utils\Entities;

use App\Utils\GeneralUtils;


class GenericUtils
{
    public static function executeSql($sql, $params): bool
    {
        global $pdo;

        try {
            // Ejecutar consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            GeneralUtils::showAlert($e->getMessage(), 'danger');
            return false;
        }
    }
}
