<?php

namespace App\Utils\Entities;

use PDO;


class IncidenceUtils
{
    private static $getAllSQL = "SELECT * FROM incidents";
    private static $createSQL = "INSERT INTO incidents (
        title,
        incidence_description,
        occurrence_date,
        latitude,
        longitude,
        n_deaths,
        n_injured,
        n_losses,
        province_id,
        municipality_id,
        neighborhood_id,
        user_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    private static $createLabelRelationSQL = "INSERT INTO incidence_labels (incidence_id, label_id) VALUES (?, ?)";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($fields, $photo_url, $labels)
    {
        global $pdo;

        // Insertar incidencia
        $stmt = $pdo->prepare(self::$createSQL);
        $stmt->execute($fields);
        $incidence_id = $pdo->lastInsertId();

        // Insertar imagen
        if (!empty($photo_url)) {
            PhotoUtils::create([$incidence_id, $photo_url]);
        }

        // Insertar relación Incidencia-Etiqueta
        if (!empty($labels)) {
            $stmt = $pdo->prepare(self::$createLabelRelationSQL);
            foreach ($labels as $label_id) {
                $stmt->execute([$incidence_id, $label_id]);
            }
        }
    }
}
