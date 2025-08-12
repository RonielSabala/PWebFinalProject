<?php

namespace App\Utils\Entities;

class CorrectionUtils extends GenericEntityUtils
{
    private static $createSql = "INSERT INTO corrections (
    incidence_id,
    user_id,
    correction_values,
    creation_date
) VALUES (?, ?, ?, NOW())";

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
}
