<?php

namespace App\Utils\Entities;


class IncidenceUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT * FROM incidents where id = ?";

    private static $getAllApprovedSql = "SELECT
        i.*,
        GROUP_CONCAT(l.label_name) AS labels,
        GROUP_CONCAT(l.icon_url) AS label_icons
    FROM
        incidents i
    JOIN
        incidence_labels il
    ON
        i.id = il.incidence_id
    JOIN
        labels l
    ON
        il.label_id = l.id
    WHERE
        i.is_approved = 1
    GROUP BY
        i.id
    ";

    private static $getAllByReporterIdSql = "SELECT
        i.id,
        i.title,
        i.incidence_description,
        i.creation_date,
        i.is_approved,
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
        i.creation_date
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

    public static function get($id)
    {
        return self::saveFetchSql(self::$getSql, [$id], 'No se encontró la incidencia.');
    }

    public static function getAllApproved(): array
    {
        $incidents = self::fetchAllSql(self::$getAllApprovedSql);
        return array_map(function ($incidence) {
            $incidence['labels'] = !empty($incidence['labels'])
                ? explode(',', $incidence['labels'])
                : [];
            $incidence['label_ids'] = !empty($incidence['label_ids'])
                ? explode(',', $incidence['label_ids'])
                : [];
            return $incidence;
        }, $incidents);
    }

    public static function getAllByReporterId($reporterId): array
    {
        return self::fetchAllSql(self::$getAllByReporterIdSql, [$reporterId]);
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
