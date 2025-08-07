<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class IncidenceUtils
{
    private static $getAllSQL = "SELECT
        i.*, 
        GROUP_CONCAT(l.label_name) AS labels,
        GROUP_CONCAT(l.id) AS label_ids
    FROM
        incidents i
    LEFT JOIN
        incidence_labels il ON i.id = il.incidence_id
    LEFT JOIN
        labels l ON il.label_id = l.id
    GROUP BY
        i.id
    ";
    private static $getAllByReporterIdSQL = "SELECT
        i.id,
        i.title,
        i.incidence_description,
        i.occurrence_date,
        COUNT(c.id) AS comments
    FROM
        incidents i
    LEFT JOIN
        comments c ON c.incidence_id = i.id
    WHERE
        i.user_id = ?
    GROUP BY
        i.id, i.title, i.incidence_description, i.occurrence_date
    ";

    private static $getByIdSQL = "SELECT * FROM incidents where id = ?";

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
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    private static $createLabelRelationSQL = "INSERT INTO incidence_labels (incidence_id, label_id) VALUES (?, ?)";

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSQL);
        $incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($incident) {
            $incident['labels'] = !empty($incident['labels'])
                ? explode(',', $incident['labels'])
                : [];
            $incident['label_ids'] = !empty($incident['label_ids'])
                ? explode(',', $incident['label_ids'])
                : [];
            return $incident;
        }, $incidents);
    }

    public static function getAllByReporterId($reporterId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getAllByReporterIdSQL);
        $stmt->execute([$reporterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($incidenceId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSQL);
        $stmt->execute([$incidenceId]);
        $incidence = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$incidence) {
            GeneralUtils::showAlert('No se encontró la incidencia.', 'danger');
            return false;
        }

        return $incidence;
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
