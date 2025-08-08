<?php

namespace App\Utils\Entities;

use PDO;
use App\Utils\GeneralUtils;


class IncidenceUtils extends GenericUtils
{
    private static $getByIdSql = "SELECT * FROM incidents where id = ?";

    private static $getAllSql = "SELECT
        i.*,
        GROUP_CONCAT(l.label_name) AS labels,
        GROUP_CONCAT(l.id) AS label_ids
    FROM
        incidents i
    LEFT JOIN
        incidence_labels il
    ON
        i.id = il.incidence_id
    LEFT JOIN
        labels l
    ON
        il.label_id = l.id
    GROUP BY
        i.id
    ";

    private static $getAllWithCommentsByReporterIdSql = "SELECT
        i.id,
        i.title,
        i.incidence_description,
        i.occurrence_date,
        COUNT(c.id) AS comments
    FROM
        incidents i
    LEFT JOIN
        comments c
    ON
        c.incidence_id = i.id
    WHERE
        i.user_id = ?
    GROUP BY
        i.id,
        i.title,
        i.incidence_description,
        i.occurrence_date
    ";

    private static $createSql = "INSERT INTO
    incidents (
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
        user_id
    )
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";

    private static $createLabelRelationSql = "INSERT INTO incidence_labels (incidence_id, label_id) VALUES (?, ?)";

    public static function getById($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getByIdSql);
        $stmt->execute([$id]);
        $incidence = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$incidence) {
            GeneralUtils::showAlert('No se encontró la incidencia.', 'danger');
            return false;
        }

        return $incidence;
    }

    public static function getAll()
    {
        global $pdo;

        $stmt = $pdo->query(self::$getAllSql);
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

    public static function getAllWithCommentsByReporterId($reporterId)
    {
        global $pdo;

        $stmt = $pdo->prepare(self::$getAllWithCommentsByReporterIdSql);
        $stmt->execute([$reporterId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($fields, $photoUrl, $labels)
    {
        global $pdo;

        // Insertar incidencia
        self::executeSql(self::$createSql, $fields);
        $incidenceId = $pdo->lastInsertId();

        // Insertar imagen
        if (!empty($photoUrl)) {
            PhotoUtils::create([$incidenceId, $photoUrl]);
        }

        // Insertar relación Incidencia-Etiqueta
        foreach ($labels as $labelId) {
            self::executeSql(self::$createLabelRelationSql, [$incidenceId, $labelId]);
        }
    }
}
