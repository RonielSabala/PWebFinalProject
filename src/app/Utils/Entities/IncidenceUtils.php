<?php

namespace App\Utils\Entities;


class IncidenceUtils extends GenericEntityUtils
{
    private static $getSql = "SELECT 
        i.*,
        u.username as reporter_name,
        GROUP_CONCAT(DISTINCT l.label_name) AS labels,
        GROUP_CONCAT(DISTINCT l.icon_url) AS label_icons,
        GROUP_CONCAT(DISTINCT l.id) AS label_ids,
        GROUP_CONCAT(DISTINCT p.photo_url) AS photo_urls
    FROM
        incidents i
    LEFT JOIN
        incidence_labels il
    ON
        il.incidence_id = i.id
    LEFT JOIN
        labels l
    ON
        il.label_id = l.id
    LEFT JOIN
        photos p
    ON
        p.incidence_id = i.id
    LEFT JOIN
        users u
    ON
        u.id = i.user_id
    WHERE
        i.id = ?
    GROUP BY
        i.id
    ";

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

    private static $getAllPendingSql = "SELECT 
        i.id,
        i.title,
        i.incidence_description,
        i.creation_date,
        i.occurrence_date,
        p.province_name,
        m.municipality_name,
        n.neighborhood_name
    FROM
        incidents i
    LEFT JOIN
        provinces p
    ON
        i.province_id = p.id
    LEFT JOIN
        municipalities m
    ON
        i.municipality_id = m.id
    LEFT JOIN
        neighborhoods n
    ON
        i.neighborhood_id = n.id
    WHERE
        i.is_approved = 0
    ORDER BY
        i.creation_date
    DESC
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

    private static $deleteSql = "DELETE FROM incidents WHERE id = ?";

    private static $createLabelRelationSql = "INSERT INTO incidence_labels (incidence_id, label_id) VALUES (?, ?)";

    private static $setApprovalSql = "UPDATE incidents SET is_approved = 1 WHERE id = ?";

    private static $getPrettyDescriptionRegex = '#
        \[(?<md_text>[^\]]+)\]\((?<md_url>https?://[^\s)]+)\)
        |(?<url>https?://[^\s<]+|www\.[^\s<]+)
        |(?<email>[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,})
    #ixu
    ';

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

    public static function getAllPending(): array
    {
        return self::fetchAllSql(self::$getAllPendingSql);
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
            if (is_array($photoUrl)) {
                foreach ($photoUrl as $url) {
                    PhotoUtils::create([$incidenceId, $url]);
                }
            } else {
                PhotoUtils::create([$incidenceId, $photoUrl]);
            }
        }

        // Insertar relación Incidencia-Etiqueta
        foreach ($labels as $labelId) {
            self::executeSql(self::$createLabelRelationSql, [$incidenceId, $labelId]);
        }
    }

    public static function delete($id): bool
    {
        return self::executeSql(self::$deleteSql, [$id]);
    }

    public static function setApproval($id): bool
    {
        return self::executeSql(self::$setApprovalSql, [$id]);
    }

    public static function getPrettyDescription(string $text): string
    {
        if ($text === '') return '';

        $lastPos = 0;
        $out = '';
        $subject = $text;
        $matches = [];
        $res = preg_match_all(self::$getPrettyDescriptionRegex, $subject, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        if ($res === false) {
            return nl2br($text);
        }

        foreach ($matches as $m) {
            $matchText = $m[0][0];
            $matchPos  = $m[0][1];
            if ($matchPos > $lastPos) {
                $chunk = substr($subject, $lastPos, $matchPos - $lastPos);
                $chunk = trim($chunk);
                if ($chunk !== '') {
                    $out .= '<p class="desc-text-run">' . nl2br(htmlspecialchars($chunk, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
                }
            }

            if (!empty($m['md_url'][0])) {
                $url = $m['md_url'][0];
                $label = $m['md_text'][0];
                $href = $url;
            } elseif (!empty($m['url'][0])) {
                $raw = $m['url'][0];
                if (stripos($raw, 'www.') === 0) {
                    $href = 'https://' . $raw;
                } else {
                    $href = $raw;
                }
                $label = $raw;
            } else {
                $email = $m['email'][0];
                $href = 'mailto:' . $email;
                $label = $email;
            }

            $esc_label = $label;
            $esc_href = $href;
            $target = (stripos($href, 'mailto:') === 0) ? '' : ' target="_blank" rel="noopener noreferrer"';
            $out .= '<a class="description-link" href="' . $esc_href . '"' . $target . '>' . $esc_label . '</a>';
            $lastPos = $matchPos + strlen($matchText);
        }

        if ($lastPos < strlen($subject)) {
            $tail = substr($subject, $lastPos);
            if (trim($tail) !== '') {
                $out .= '<p class="desc-text-run">' . nl2br(htmlspecialchars($tail, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')) . '</p>';
            }
        }

        return $out;
    }
}
