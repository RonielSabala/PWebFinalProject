<?php

namespace App\Utils\Entities;


class CorrectionUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM corrections WHERE id = ?";

    private static $getAllPendingSql = "SELECT 
        c.id,
        c.incidence_id,
        u.username,
        c.correction_values,
        c.creation_date
    FROM
        corrections c
    JOIN
        users u
    ON
        u.id = c.user_id
    WHERE
        c.is_approved = 0
    ORDER BY
        c.creation_date
    DESC
    ";

    private static $createSql = "INSERT INTO
    corrections (
        incidence_id,
        user_id,
        correction_values
    )
    VALUES
        (?, ?, ?)
    ";

    private static $deleteSql = "DELETE FROM corrections WHERE id = ?";

    private static $setApprovalSql = "UPDATE corrections SET is_approved = 1 WHERE id = ?";

    private static $applySql = "UPDATE
        incidents
    SET
        latitude = ?,
        longitude = ?,
        n_deaths = ?,
        n_injured = ?,
        n_losses = ?,
        province_id = ?,
        municipality_id = ?,
        neighborhood_id = ?
    WHERE
        id = ?
    ";

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró la corrección.');
    }

    public static function getAllPending(): array
    {
        return self::fetchAllSql(self::$getAllPendingSql);
    }

    public static function create($incidenceId, $userId, $correctionData)
    {
        // Formatear datos para el Json
        if (isset($correctionData['labels'])) {
            $correctionData['labels'] = is_array($correctionData['labels'])
                ? $correctionData['labels']
                : json_decode($correctionData['labels'], true);
        }

        $numericFields = ['n_deaths', 'n_injured', 'n_losses', 'province_id', 'municipality_id', 'neighborhood_id'];
        foreach ($numericFields as $field) {
            if (isset($correctionData[$field])) {
                $correctionData[$field] = (int)$correctionData[$field];
            }
        }

        $floatFields = ['latitude', 'longitude'];
        foreach ($floatFields as $field) {
            if (isset($correctionData[$field])) {
                $correctionData[$field] = (float)$correctionData[$field];
            }
        }

        $jsonData = json_encode($correctionData, JSON_UNESCAPED_UNICODE);
        return self::executeSql(
            self::$createSql,
            [
                $incidenceId,
                $userId,
                $jsonData
            ]
        );
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }

    public static function setApproval($id): bool
    {
        return self::executeSql(self::$setApprovalSql, [$id]);
    }

    public static function apply($correction): bool
    {
        $data = json_decode($correction['correction_values'], true);
        return self::executeSql(
            self::$applySql,
            [
                $data['latitude'],
                $data['longitude'],
                $data['n_deaths'],
                $data['n_injured'],
                $data['n_losses'],
                $data['province_id'],
                $data['municipality_id'],
                $data['neighborhood_id'],
                $correction['incidence_id'],
            ]
        );
    }
}
