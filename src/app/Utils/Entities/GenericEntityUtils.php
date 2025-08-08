<?php

namespace App\Utils\Entities;

use App\Utils\GeneralUtils;
use PDO;


class GenericEntityUtils
{
    public static function executeSql(string $sql, array $params): bool
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

    public static function fetchSql(string $sql, array $params)
    {
        global $pdo;

        try {
            // Ejecutar consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            GeneralUtils::showAlert($e->getMessage(), 'danger');
            return null;
        }
    }

    public static function fetchAllSql(string $sql, array $params = []): array
    {
        global $pdo;

        try {
            // Ejecutar consulta
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            GeneralUtils::showAlert($e->getMessage(), 'danger');
            return [];
        }
    }
}
